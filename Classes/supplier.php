<?php
class Supplier {
    private const TABLE = "Supplier";
    private int $id;
    private string $name;
    private string $number;

    public function __construct(int $id, string $name, string $number) {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
    }

    public static function create(array $SupplierData) : Supplier {
        $stmt = DB::getInstance()->connect->prepare("INSERT INTO `Supplier` (
            `name`,
            `number`
            ) 
        VALUES 
        ( 
            :n,  
            :nu
        )"
    );
        $stmt->execute(["n"=>$SupplierData['name'],"nu"=>$SupplierData['number']]);

        $id = DB::getInstance()->connect->lastInsertId();
        $Supplier = new Supplier ($id, $SupplierData['name'], $SupplierData['number']);

        return $Supplier;
    }

    public function update(): Supplier {
        $stmt = DB::getInstance()->connect->prepare("UPDATE `Supplier`
            SET
            `name`=:n,
            `number`=:nu
            where `id`=:id");
        $stmt->execute(["n"=>$this->name,"nu"=>$this->number,"id"=>$this->id]);

        return $this;
    }

    public static function delete(int $id): void {
        $result = DB::getInstance()->connect->query("select `Crop`.`Supplier_id` AS `Supplier_id` from (`Crop` join `Supplier` on((`Crop`.`Standard_id` = `Supplier`.`id`))) GROUP BY `Supplier_id`");
        $list = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach($list as $k => $v){
            if ($id==$v['Supplier_id']){
                return null;
            } else {
                $delete = DB::getInstance()->connect->prepare("DELETE from Supplier where id = :id");
                $delete->execute(["id"=>$id]);
            }
        }
    }

    public static function findById(int $id): Supplier {
        $stmt = DB::getInstance()->connect->prepare("SELECT * FROM `Supplier` WHERE `id`=:id");
        $stmt->execute(["id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $Supplier = new Supplier(
            $row['id'],
            $row['name'],
            $row['number']
        );

        return $Supplier;
    }

    public static function findAll(): array {
        $stmt = DB::getInstance()->connect->query("SELECT * FROM `Supplier`");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $Suppliers = array();

        foreach ($results as $result) {
            $Supplier = new Supplier(
                $result['id'],
                $result['name'],
                $result['number']
            );
            $Suppliers[] = $Supplier;
        }

        return $Suppliers;
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

    public function getNumber(): string {
        return $this->number;
    }

    public function setNumber($number): void {
        $this->number = $number;
    }
}
?>