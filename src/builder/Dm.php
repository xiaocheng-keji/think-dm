<?php
/**
 * 71CMS (c) 南宁小橙科技有限公司
 * 网站地址: http://71cms.net
 * Author: y.Lee <86332603@qq.com>
 * Date: 2022/03/24
 * Time: 10:05
 */

namespace think\db\builder;

use think\db\Builder;
use think\db\Expression;
use think\db\Query;

/**
 * 达梦数据库驱动
 */
class Dm extends Builder
{
    /**
     * 字段和表名处理
     * @access protected
     * @param mixed  $key
     * @param array  $options
     * @return string
     */
    protected function parseKey($key, $options = [], $strict = false)
    {
        if (is_numeric($key)) {
            return $key;
        } elseif ($key instanceof Expression) {
            return $key->getValue();
        }
        $key = trim($key);

        if (strpos($key, '.')) {
            list($table, $key) = explode('.', $key, 2);

            $alias = $this->query->getOptions('alias');

            if ('__TABLE__' == $table) {
                $table = $this->query->getOptions('table');
                $table = is_array($table) ? array_shift($table) : $table;
            }

            if (isset($alias[$table])) {
                $table = $alias[$table];
            }
        }

        $key = str_replace('`', '', $key);
        if ('*' != $key && !preg_match('/[,\'\"\*\(\).\s]/', $key)) {
            $key = '"' . $key . '"';
        }

        if (isset($table)) {
            $key = $table . '.' . $key;
        }

        return $key;
    }

    /**
     * 随机排序
     * @access protected
     * @param  Query     $query        查询对象
     * @return string
     */
    protected function parseRand(Query $query)
    {
        return 'RAND()';
    }
}
