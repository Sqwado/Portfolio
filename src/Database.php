<?php

class Database
{
    private $connection;
    private $sql;
    private $stmt;
    public $data;

    public function __construct(
        private string $host,
        private string $port,
        private string $name,
        private string $user,
        private string $password
    ) {
        $this->getConnection();
    }

    public function getConnection(): void
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->name};charset=utf8";
        $this->connection = new PDO($dsn, $this->user, $this->password, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }

    public function presql(string $sql): void
    {
        $this->sql = $sql;
        $this->stmt = $this->connection->prepare($this->sql);
    }

    public function bindParam(string $param, $value): void
    {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;

            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;

            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;

            default:
                $type = PDO::PARAM_STR;
        }

        $this->stmt->bindParam($param, $value, $type);
    }

    public function execute(): void
    {
        $this->stmt->execute();
        
        $data = [];

        while ($row = $this->stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $this->data = $data;
    }
}
