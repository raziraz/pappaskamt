<?php
namespace Deployer;

// Configuration.
$branch = 'develop';

// -- DON'T EDIT BELOW THIS LINE --

require_once 'recipe/common.php';

// Set composer options.
set('composer_options', '{{composer_action}} --no-dev --verbose --prefer-dist --optimize-autoloader --no-progress --no-interaction --no-scripts');

// Set release name.
set('release_name', function () {
    // Set the deployment timezone
    if (!date_default_timezone_set(get('timezone', 'UTC'))) {
        date_default_timezone_set('UTC');
    }
    return date('YmdHis');
});

// Update code task.
task('deploy:update_code', function () {
    $branch = get('branch') ? get('branch') : 'master';
    $ci = getenv('CI_COMMIT_SHA') ?: '';
    $verbose = '';

    // Remove invalid characters in filename
    $branch_filename = mb_ereg_replace("([^\w\s\d\-_])", '', $branch);

    $tarballPath = '/tmp/{{release_name}}-' . $branch_filename . '.gz';

    if (isVerbose()) {
        $verbose = '-v';
    }

    // Extract from git to tarball.
    if (!empty($ci)) {
        runLocally("git archive --format=tar $verbose HEAD | bzip2 > $tarballPath");
    } else {
        runLocally("git fetch --all");
        $local_commit = runLocally("git rev-parse $branch")->toString();
        $remote_commit = runLocally("git rev-parse origin/$branch")->toString();

        if ($local_commit !== $remote_commit) {
            writeln("<fg=red>></fg=red> Branch $branch not in sync with origin/$branch");
            exit(1);
        }
        runLocally("git archive --format=tar $verbose $branch | bzip2 > $tarballPath");
    }

    if (isVerbose()) {
        writeln("<fg=green>></fg=green> Successfully archived to $tarballPath");
    }

    // Upload tarball.
    upload($tarballPath, $tarballPath);

    // Extract tarball.
    run("sudo mkdir -p {{deploy_path}}/tar/$branch");
    run("sudo chown -R {{user}}:{{group}} {{deploy_path}}/tar");
    run("tar -xf $tarballPath -C {{deploy_path}}/tar/$branch");
    run("find {{deploy_path}}/tar/$branch/ -mindepth 1 -maxdepth 1 -exec mv -t {{release_path}}/ -- {} +");

    // Cleanup.
    run("rm -rf {{deploy_path}}/tar");
    run("rm $tarballPath");
})->desc('Updating code');

// Installing vendor packages tasks.
task('deploy:vendors', function () {
    $composer = get('bin/composer');
    $envVars = get('env_vars') ? 'export ' . get('env_vars') . ' &&' : '';
    $githubToken = has('github_token') ? get('github_token') : '';

    if (!empty($githubToken)) {
        run("cd {{release_path}} && $envVars $composer config -g github-oauth.github.com $githubToken");
    }

    run("cd {{release_path}} && $envVars $composer {{composer_options}}");
})->desc('Installing vendors');

// Set user and group.
set('user', 'root');
set('group', 'www-data');

// Set test server.
server('test', 'pappaskamt.test.krig.io')
    ->user('root')
    ->set('branch', $branch)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->set('deploy_path', '/var/www/pappaskamt.krig.io')
    ->stage('test');

// Set git configuration.
set('repository', 'https://github.com/raziraz/pappaskamt.git');

// Set ssh configuration.
set('ssh_type','native');
set('ssh_multiplexing', true);

// Set shared files and directories.
set('shared_files', ['.env']);
set('shared_dirs', ['web/app/uploads']);

// Set deploy order.
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:vendors',
    'deploy:shared',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);
