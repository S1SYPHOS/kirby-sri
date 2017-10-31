# kirby-sri-hash
This plugin is heavily inspired by the great Kirby plugins [cachebuster](https://github.com/getkirby-plugins/cachebuster-plugin) (by Kirby team members [Bastian Allgeier](https://github.com/bastianallgeier) and [Lukas Bestle](https://github.com/lukasbestle)) as well as [fingerprint](https://github.com/iksi/kirby-fingerprint) (by [Iksi](https://github.com/iksi)).

## What's SRI?
TL;DR: I wanted to add Kirby-side [subresource integrity](https://developer.mozilla.org/en-US/docs/Web/Security/Subresource_Integrity) (SRI) for [safer CDN usage](https://hacks.mozilla.org/2015/09/subresource-integrity-in-firefox-43/). Read more about CDN integration and Kirby in the [docs](https://getkirby.com/docs/cookbook/kirby-loves-cdn)) or over at Kirby's partner [KeyCDN]( [tutorials](https://www.keycdn.com/support/kirby-cdn-integration/).

## Installation
Use one of these alternatives in order to use install & use `kirby-sri-hash`:

### 1. Git Submodule

If you know your way around Git, you can download this plugin as a [submodule](https://github.com/blog/2104-working-with-submodules):

```text
git submodule add https://github.com/S1SYPHOS/kirby-sri-hash.git site/plugins/kirby-sri-hash
```

### 2. Clone or download

1. [Clone](https://github.com/S1SYPHOS/kirby-sri-hash.git) or [download](https://github.com/S1SYPHOS/kirby-sri-hash/archive/master.zip)  this repository.
2. Unzip / Move the folder to `site/plugins`.

### 3. Activate the plugin
Activate the plugin with the following line in your `config.php`:

```text
c::set('sri-hash', true);
```

#### Apache
Add the following lines to your `.htaccess` (right after `RewriteBase`):

```
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)\.([0-9]{10})\.(js|css)$ $1.$3 [L]
```

#### NGINX
Add the following lines to your virtual host setup:

```
location /assets {
  if (!-e $request_filename) {
    rewrite "^/(.+)\.([0-9]{10})\.(js|css)$" /$1.$3 break;
  }
}
```

**Note: Subresource integrity & cache-busting are not applied to external URLs!**

## Special Thanks
I'd like to thank everybody that's making great software - you people are awesome. Also I'm always thankful for feedback and bug reports :)
