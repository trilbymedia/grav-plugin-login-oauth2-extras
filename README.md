# Login Login OAuth2 Extras Plugin

**This README.md file should be modified to describe the features, installation, configuration, and general usage of this plugin.**

The **Login Login OAuth2 Extras** Plugin is for [Grav CMS](http://github.com/getgrav/grav). OAuth2 Provider for Extras

## Providers

* **GitLab:** https://docs.gitlab.com/ee/integration/oauth_provider.html
* **Discord:** https://extrasapp.com/developers/docs/topics/oauth2
* **Slack:** https://api.slack.com/docs/sign-in-with-slack
* **Jira:** https://developer.atlassian.com/server/jira/platform/oauth/

## Installation

Installing the Login Login OAuth2 Extras plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install login-oauth2-extras

This will install the Login Login OAuth2 Extras plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/login-oauth2-extras`.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/login-oauth2-extras/login-oauth2-extras.yaml` to `user/config/plugins/login-oauth2-extras.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
built_in_css: true
providers:
  discord:
    enabled: false
    client_id: ''
    client_secret: ''
    options:
      scope: ['identify', 'email']
  slack:
    enabled: false
    client_id: ''
    client_secret: ''
    options:
      scope: ['users:read', 'users:read.email']
  jira:
    enabled: false
    client_id: ''
    client_secret: ''
    options:
      scope: ['read:jira-user']

admin:
  enabled: true
  built_in_css: true
  providers:
    discord:
      enabled: false
      client_id: ''
      client_secret: ''
      options:
        scope: ['identify', 'email']
    slack:
      enabled: false
      client_id: ''
      client_secret: ''
      options:
        scope: ['users:read', 'users:read.email']
    jira:
      enabled: false
      client_id: ''
      client_secret: ''
      options:
        scope: ['read:jira-user']
```

Note that if you use the admin plugin, a file with your configuration, and named login-oauth2-extras.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.


## Credits

**Did you incorporate third-party code? Want to thank somebody?**

## To Do

- [ ] Future plans, if any

