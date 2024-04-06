<?php
/**
 * 71CMS (c) 南宁小橙科技有限公司
 * 网站地址: http://71cms.net
 * Author: y.Lee <86332603@qq.com>
 * Date: 2022/03/24
 * Time: 10:05
 */

namespace think\db\connector;

use PDO;
use think\db\Connection;

/**
 *  达梦数据库驱动
 */
class Dm extends Connection
{
    /**
     * 解析pdo连接的dsn信息
     * @access protected
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn($config)
    {
        $dsn = 'dm:host=' . $config['hostname'];

        if (!empty($config['hostport'])) {
            $dsn .= ':' . $config['hostport'];
        }
        return $dsn;
    }

    /**
     * 取得数据表的字段信息
     * @access public
     * @param string $tableName
     * @return array
     */
    public function getFields($tableName)
    {
        $config = $this->getConfig();
        $sql = "select * from all_tab_columns where table_name='{$tableName}' AND OWNER='{$config['username']}'";
        $pdo = $this->query($sql, [], false, true);
        $result = $pdo->fetchAll(PDO::FETCH_ASSOC);
        $info = [];

        if ($result) {
            foreach ($result as $key => $val) {
                $val = array_change_key_case($val);
                $info[$val['column_name']] = [
                    'name' => $val['column_name'],
                    'type' => $val['data_type'],
                    'notnull' => 'Y' === $val['nullable'],
                    'default' => $val['data_default'],
                    'primary' => $val['column_name'] === 'id',
                    'autoinc' => false,
                ];
            }
        }

        return $this->fieldCase($info);
    }

    /**
     * 取得数据库的表信息
     * @access   public
     * @param string $dbName
     * @return array
     */
    public function getTables($dbName = '')
    {
        $config = $this->getConfig();
        $sql = "select table_name from all_tables where OWNER='{$config['username']}'";
        $pdo = $this->getPDOStatement($sql);
        $result = $pdo->fetchAll(PDO::FETCH_ASSOC);
        $info = [];

        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }

        return $info;
    }

    /**
     * SQL性能分析
     * @access protected
     * @param string $sql
     * @return array
     */
    protected function getExplain($sql): array
    {
        return [];
    }

    protected function supportSavepoint(): bool
    {
        return true;
    }
}
