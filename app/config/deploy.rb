# Application
logger.level = Logger::DEBUG

set :application, "dicephrase"
set :domain,      "dicephrase.com"
set :deploy_to,   "/var/www/#{domain}"

# Repository
set :repository,  "git@github.com:pradodigital/dicephrase.git"
set :scm,         :git

# Symfony Configuration
set :use_composer,    true
set :shared_files,    ["app/config/parameters.yml"]
set :shared_children, [app_path + "/logs"]

role :web, "awsweb02.pradodigital.com"                   # Your HTTP server, Apache/etc
role :app, "awsweb02.pradodigital.com", :primary => true # This may be the same as your `Web` server

set :user,          "ec2-user"
set :use_sudo,      false
set :keep_releases, 3

set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "apache"
set :permission_method,   :acl
set :use_set_permissions, true
