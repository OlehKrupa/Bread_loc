<?php
namespace Bread\classes;

class Warehouse {
    private const TABLE = "Warehouse";
    private int $id;
    private string $name;
    private string $address;
    private float $capacity;

    public function __construct(int $id, string $name, string $address, float $capacity) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->capacity = $capacity;
    }

    public static function create(array $WarehouseData) : Warehouse {
        $stmt = DB::getInstance()->connect->prepare("INSERT INTO `Warehouse` (
                `name`,
                `address`,
                `capacity`
                ) 
            VALUES 
            ( 
                :n,  
                :a,
                :c
            )"
        );
        $stmt->execute(["n"=>$WarehouseData['name'],"a"=>$WarehouseData['address'],"c"=>$WarehouseData['capacity']]);

        $id = DB::getInstance()->connect->lastInsertId();
        $warehouse = new Warehouse ($id, $WarehouseData['name'], $WarehouseData['address'], $WarehouseData['capacity']);

        return $warehouse;
    }

    public function update(): Warehouse {
        $stmt = DB::getInstance()->connect->prepare("UPDATE `Warehouse`
            SET
            `name`=:n,
            `address`=:a,
            `capacity`=:c
            where `id`=:id");
        $stmt->execute(["n"=>$this->name,"a"=>$this->address,"c"=>$this->capacity,"id"=>$this->id]);

        return $this;
    }

    public static function delete(int $id): void {
        $result = DB::getInstance()->connect->query("select `Crop`.`Warehouse_id` AS `Warehouse_id` from (`Crop` join `Warehouse` on((`Crop`.`Warehouse_id` = `Warehouse`.`id`))) GROUP BY `Warehouse_id`");
        $list = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach($list as $k => $v){
            if ($id==$v['Warehouse_id']){
                //Если склад используется то не удаляем
                return null;
            } else {
                $delete = DB::getInstance()->connect->prepare("DELETE from Warehouse where id = :id");
                $delete->execute(["id"=>$id]);
            }
        }
    }

    public static function findById(int $id): Warehouse {
        $stmt = DB::getInstance()->connect->prepare("SELECT * FROM `Warehouse` WHERE `id`=:id");
        $stmt->execute(["id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $warehouse = new Warehouse(
            $row['id'],
            $row['name'],
            $row['address'],
            $row['capacity']
        );

        return $warehouse;
    }

    public static function findAll(): array {
        $stmt = DB::getInstance()->connect->query("SELECT * FROM `Warehouse`");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $warehouses = array();

        foreach ($results as $result) {
            $warehouse = new Warehouse(
                $result['id'],
                $result['name'],
                $result['address'],
                $result['capacity']
            );
            $warehouses[] = $warehouse;
        }

        return $warehouses;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function setAddress($address): void {
        $this->address = $address;
    }

    public function getCapacity(): float {
        return $this->capacity;
    }

    public function setCapacity($capacity): void {
        $this->capacity = $capacity;
    }
}
?>