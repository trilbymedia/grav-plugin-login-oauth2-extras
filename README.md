# Login Login OAuth2 Extras Plugin

The **Login Login OAuth2 Extras** Plugin is for [Grav CMS](http://github.com/getgrav/grav). This plugin provides extra authenticatoin providers not included in the [Login OAuth2 Plugin](http://github.com/trilbymedia/grav-plugin-login-oauth2). 


**NOTE:** Please use the same **Callback URIs** and configuration from **Login OAuth2 Plugin**.

Currently the plugin supports the following providers:

* **GitLab:** - https://docs.gitlab.com/ee/integration/oauth_provider.html
* **Discord:** - https://extrasapp.com/developers/docs/topics/oauth2
* **Slack:** - https://api.slack.com/docs/sign-in-with-slack
* **Jira:** - https://developer.atlassian.com/server/jira/platform/oauth/
* **Twitch** - https://dev.twitch.tv/docs/authentication/getting-tokens-oauth/
* **Azure** - https://docs.microsoft.com/en-us/azure/active-directory/develop/quickstart-register-app
* **Patreon** - https://docs.patreon.com/#oauth
* **Keycloak** - https://github.com/stevenmaguire/oauth2-keycloak
* **Okta** - https://github.com/foxworth42/oauth2-okta

If you wish to add a new provider, please open a pull request against this repo.

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
  gitlab:
    enabled: false
    client_id: ''
    client_secret: ''
    domain:
    options:
      scope: ['read_user', 'openid']
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
  twitch:
    enabled: false
    client_id: ''
    client_secret: ''
    options:
      scope: ['user_read']
  azure:
    enabled: false
    tenant: 'common'
    client_id: ''
    client_secret: ''
    options:
      scope: ['openid', 'email', 'profile', 'offline_access', 'User.Read']
      get_groups: false
      avatar_max_size: 240
  patreon:
    enabled: false
    client_id: ''
    client_secret: ''
    options:
      scope: ['users']
  keycloak:
    enabled: false
    authserver_url: ''
    realm: ''
    client_id: ''
    client_secret: ''
    options:
      scope: ['users']
    userdata_login: ''
    userdata_fullname: ''
    userdata_email: ''
  okta:
    enabled: false
    client_id:
    client_secret:
    issuer:
    options:
      scope: ['openid', 'email', 'profile']
  

admin:
  enabled: true
  built_in_css: true
  providers:
    gitlab:
      enabled: false
      client_id: ''
      client_secret: ''
      domain:
      options:
        scope: ['read_user', 'openid']
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
    twitch:
      enabled: false
      client_id: ''
      client_secret: ''
      options:
        scope: ['user_read']
    azure:
      enabled: false
      tenant: 'common'
      client_id: ''
      client_secret: ''
      options:
        scope: ['openid', 'email', 'profile', 'offline_access', 'User.Read']
        get_groups: false
        avatar_max_size: 240
    patreon:
      enabled: false
      client_id: ''
      client_secret: ''
      options:
        scope: ['users']
    keycloak:
      enabled: false
      authserver_url: ''
      realm: ''
      client_id: ''
      client_secret: ''
      options:
        scope: ['users']
      userdata_login: ''
      userdata_fullname: ''
      userdata_email: ''
    okta:
      enabled: false
      client_id:
      client_secret:
      issuer:
      options:
        scope: ['openid', 'email', 'profile']
```

Note that if you use the admin plugin, a file with your configuration, and named login-oauth2-extras.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

### OAuth2 Providers

#### GitLab

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|client_id|The **Client ID** Provided by GitLab when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by GitLab when you register an application for OAuth2 authentication | `<string>` |
|domain|A custom GitLab domain| `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['read_user', 'openid']` |

#### Discord

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|client_id|The **Client ID** Provided by Discord when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Discord when you register an application for OAuth2 authentication | `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['identify', 'email']` |

#### Slack

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|client_id|The **Client ID** Provided by Slack when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Slack when you register an application for OAuth2 authentication | `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['users:read', 'users:read.email']` |

#### Jira

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|client_id|The **Client ID** Provided by Jira when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Jira when you register an application for OAuth2 authentication | `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['read:jira-user']` |

#### Twitch

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|client_id|The **Client ID** Provided by Twitch when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Twitch when you register an application for OAuth2 authentication | `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['user_read']` |

#### Azure

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|tenant|The **Tenant ID** of your Azure AD tenant that you want to use. Use 'common' for all users, 'organizations' for Azure AD work or school accounts, 'consumers' for personal Microsoft accounts or a tenant id for accounts from a single Azure AD tenant.|`common`, `organizations`, `consumers`, e.g. `58673e44-617a-4d61-88b5-fb480759a841`|
|client_id|The **Client ID** Provided by Azure when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Azure when you register an application for OAuth2 authentication | `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['openid', 'email', 'profile', 'offline_access', 'User.Read']` |
|get_groups|Add all the groups from Azure to the users, which includes transitive memberships. This needs at least the `GroupMember.Read.All` scope as well, which needs admin consent. **Warning**: if you save the users the groups will only be added, but not removed.| `true` \| [default: `false`] |
|avatar_max_size|The maximum size in pixels of the avatar to store. Azure does not provide all sizes, only 48x48, 64x64, 96x96, 120x120, 240x240, 360x360, 432x432, 504x504, and 648x648. | e.g. `240` |

#### Patreon

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|client_id|The **Client ID** Provided by Patreon when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Patreon when you register an application for OAuth2 authentication | `<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['users']` |

#### Keycloak

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
|enabled|Enable or disable this specific provider. This stops its showing as an valid login option| `true` \| [default: `false`] |
|authserver_url| The **AuthServer URL** of your Keycloak server that you want to use. |`<string>` |
|realm| The **Realm** of your Keycloak server that you want to use. |`<string>` |
|client_id|The **Client ID** Provided by Keycloak when you register an application for OAuth2 authentication | `<string>` |
|client_secret|The **Client Secret** Provided by Keycloak when you register an application for OAuth2 authentication | `<string>` |
|encryption_algorithm| The **Encryption Algorithm** to be used, if your Keycloak instance is configured to use encryption. |`<string>` \| e.g. `RS256` |
|encryption_key| The contents of your public key or certificate that should be used for decryption, if your Keycloak instance is configured to use encryption. |`<string>` |
|scope|An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | e.g. `['users']` |
|userdata_login| The **Login** key of the Keycloak user data.|`<string>` |
|userdata_fullname| The user's **full name** key of the Keycloak user data.|`<string>` \| e.g. `name` |
|userdata_email| The user's **email address** key of the Keycloak user data.|`<string>` \| e.g. `email` |

#### Okta

|Key                   |Description                 | Values |
|:---------------------|:---------------------------|:-------|
| enabled | Enable or disable this specific provider. This stops its showing as an valid login option | `true` \| [default: `false`] |
| client_id | The **Client ID** Provided by Okta when you register an application for OAuth2 authentication | `` |
| client_secret | The **Client Secret** Provided by Okta when you register an application for OAuth2 authentication | `` |
| issuer | The **Issuer** Provided by Okta when you register an application for OAuth2 authentication | `` |
| scope | An array of strings that define the OAuth2 scope. These can enable retrieving more data, but often require more permissions | default: `['openid', 'email', 'profile']` |
