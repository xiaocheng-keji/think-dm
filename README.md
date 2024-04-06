ThinkPHP 5.0 达梦数据库驱动
===============
---
[ThinkPHP 5.0 版](https://gitee.com/xiaocheng_keji/think-dm/tree/1.x) 对应 1.x 分支  
[ThinkPHP 5.1 版](https://gitee.com/xiaocheng_keji/think-dm/tree/2.x) 对应 2.x 分支  
[ThinkPHP 6.0 版](https://gitee.com/xiaocheng_keji/think-dm/tree/3.x) 对应 3.x 分支
---
原来为 [71CMS创先云党建](https://gitee.com/xiaocheng_keji/71cms)  从 MySQL 移植到 DM 写的，现在开源出来，供大家学习交流。

此驱动基于 PDO 的达梦数据库扩展，需要先安装达梦数据库的 PDO 扩展，命令行中执行 php –m 需要 有 PDO 和 PDO_DM

当时的达梦 dm_svc.conf 配置：
~~~
TIME_ZONE=(480)
LANGUAGE=(cn)
CHAR_CODE=(PG_UTF8)
KEYWORDS=(user,label)
~~~

dm.ini 配置：
~~~
COMPATIBLE_MODE=4
~~~

然后，配置应用的数据库配置：

~~~
TYPE = dm
HOSTNAME = localhost
USERNAME = SYSDBA
PASSWORD = SYSDBA
HOSTPORT = 5236
CHARSET = utf8
PREFIX = xc_
DEBUG = true
~~~

即可正常使用达梦数据库，例如：
~~~
Db::name('demo')
    ->find();
Db::name('demo')
    ->field('id,name')
    ->limit(10)
    ->order('id','desc')
    ->select();
~~~