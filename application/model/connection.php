<?php

    abstract class abstractConnection
    {
        abstract protected function select($value, $table, $where = '', $order = '', $limit = '', $report = '');
        abstract protected function insert($table, $values, $report = '');
        abstract protected function update($table, $value, $where = '', $report = '');
        abstract protected function delete($table, $where = '', $report = '');
    }

    class connection extends abstractConnection
    {
        public $sql_query_select;
        public $mysql;

        protected function __construct()
        {
            $connectInfo = parse_ini_file(__DIR__ . "/connection.ini");
            $mysqli = new mysqli($connectInfo['hostname'], $connectInfo['login'], $connectInfo['password'], $connectInfo['database']);
            $this->mysql = $mysqli;
            mysqli_set_charset($mysqli, 'utf8');
        }

        protected function select($value, $table, $where = '', $order = '', $limit = '', $report = '')
        {
            if ((stripos("{$value}","COUNT") !== false) || (stripos("{$value}","MAX") !== false)) { $value = "{$value}"; }
            elseif (($value != '*') && (stripos("{$value}","DISTINCT") === false)) { $value = "{$value}"; }

            if ($where != null) { $where = " WHERE {$where} "; }

            if (($order != null) && (stripos("{$order}","GROUP BY") === false)) { $order = " ORDER BY {$order} "; }

            if ($limit != null) { $limit = " LIMIT {$limit}"; }
            $this->sql_query_select = $this->mysql->query("SELECT {$value} FROM {$table}{$where}{$order}{$limit}");
            if ($report == '1')
            { echo "<div style = 'background: darkblue; color: yellow;'>SELECT {$value} FROM {$table}{$where}{$order}{$limit}</div>"; }

            return $this->sql_query_select;
        }

        protected function insert($table, $values, $report = '')
        {
            $this->mysql->query("INSERT INTO {$table} VALUES ({$values})");
            if ($report == '1')
            { echo "INSERT INTO {$table} VALUES ({$values})<br>"; }
        }

        protected function update($table, $value, $where = '', $report = '')
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysql->query("UPDATE {$table} SET {$value}{$where}");
            if ($report == '1')
            { echo "<div style = 'background: darkblue; color: yellow;'>UPDATE {$table} SET {$value}{$where}</div>"; }
        }

        protected function delete($table, $where = '', $report = '')
        {
            if ($where != null) { $where = " WHERE {$where}"; }
            $this->mysql->query("DELETE FROM `{$table}`{$where}");
            if ($report == '1') { echo "DELETE FROM `{$table}`{$where}<br>"; }
        }

        public function __destruct()
        {
            mysqli_close($this->mysql);
        }
    }