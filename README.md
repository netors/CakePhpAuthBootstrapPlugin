CakePhpAuthBootstrapPlugin
==========================

Plugin to quickly bootstrap basic Authentication with ACL

To use:

```git submodule clone https://github.com/netors/CakePhpAuthBootstrapPlugin app/Plugin/AuthBootstrap```

You will need other Plugins too:

```git submodule add https://github.com/slywalker/TwitterBootstrap.git app/Plugin/TwitterBootstrap```
```git submodule add https://github.com/netors/TwitterBootstrapCakeBakePlugin.git app/Plugin/TwitterBootstrapCakeBake```
```git submodule add git://github.com/lecterror/cakephp-filter-plugin.git app/Plugin/Filter```
```git submodule add git@gits.mxtrio.com:/home/git/repositories/cakephp-acl.git app/Plugin/Acl```

Create your users and roles tables using the SQL script at:

```app/Config/Schema/users_roles_tables.sql```

