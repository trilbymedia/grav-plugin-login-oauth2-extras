# v2.2.2
## 08/13/2026

1. [](#bugfix)
    * Fixed Keycloak and the other extra providers never showing up on the new admin's login screen ([#13](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/issues/13)). Requires Login OAuth2 2.2.8.
    * Fixed providers reading their credentials from the site config instead of the admin config when signing in to the new admin.
    * Fixed a PHP warning when a configured provider has no `enabled` setting.

# v2.2.1
## 04/30/2026

1. [](#bugfix)
    * Fixed PHP 8.1+ deprecation notice — explicit string casts where `null` was being passed to string-typed function arguments.

# v2.2.0
## 03/30/2022

1. [](#new)
   * Added Okta provider [#7](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/pull/7)
2. [](#bugfix)
   * Fixed issues with TwitchHelix provider [#6](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/issues/6)
   
# v2.1.2
## 03/16/2022

1. [](#new)
   * Added Keycloak provider [#5](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/pull/5)
2. [](#improved)
   * Updated Twitch provider to TwitchHelix [#6](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/issues/6)
   * Updated all vendor libraries to latest

# v2.1.1
## 12/02/2020

1. [](#improved)
    * Azure - Add tenant option for OpenID scopes [#3](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/pull/3)
    * Azure - Get profile picture form Azure [#3](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/pull/3)
    * Azure - Get group memberships from Azure [#3](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/pull/3)

# v2.1.0
## 05/11/2020

1. [](#new)
    * Added Patreon Provider
    * Added Azure Provider [#1](https://github.com/trilbymedia/grav-plugin-login-oauth2-extras/pull/1)

# v2.0.1
## 04/27/2019

1. [](#new)
    * Added Twitch Provider

# v2.0.0
##  04/26/2019

1. [](#new)
    * ChangeLog started...
