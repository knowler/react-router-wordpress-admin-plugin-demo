# React Router in a WordPress Admin Plugin

Using a pattern like this for a plugin means that there is no
page refresh between the subpages of your WordPress admin
plugin.

The key is [React Portals](http://reactjs.org/docs/portals.html). 
We can “take over” the WordPress admin menu for our plugin using
them and render our own “imposter” menu that is controlled by
[React Router](https://reacttraining.com/react-router/web/).

## Try it out

```shell
# Go to the plugins directory
$ cd wp-content/plugins

# Clone this repo
$ git clone https://github.com/knowler/react-router-wordpress-admin-plugin-demo.git

# Go to the plugin
$ cd react-router-wordpress-admin-plugin-demo

# Install Composer dependencies
$ composer install

# Install Node dependencies
$ yarn

# Build plugin assets
$ yarn build

# Activate the plugin
$ wp plugin activate react-router-wordpress-admin-plugin-demo

# Go to WordPress admin to see for yourself
```

## Optimizations

This is intended to a proof of concept. I’m know optimizations
could be made, but that wasn’t important for this demo.
