<?php
namespace Bread\classes;

class ConsignmentOut {
    private const TABLE = "Consignment_OUT";
    private int $id;
    private int $cropId;
    private float $amount;
    private string $date;
    private string $name;
    private string $number;
    private float $moisture;
    private float $garbage;
    private float $minerals;
    private float $nature;

    public function __construct(int $id, int $cropId, float $amount, string $date, string $name, string $number, float $moisture, float $garbage, float $minerals, float $nature) {
        $this->id = $id;
        $this->cropId = $cropId;
        $this->amount = $amount;
        $this->date = $date;
        $this->name = $name;
        $this->number = $number;
        $this->moisture = $moisture;
        $this->garbage = $garbage;
        $this->minerals = $minerals;
        $this->nature = $nature;
    }

    public static function create(array $ConsignmentOutData) : ConsignmentOut {
        $stmt = DB::getInstance()->connect->prepare("INSERT INTO `Consignment_OUT` (
                `Crop_id`,
                `amount`,
                `name`,
                `number`,
                `moisture`,
                `garbage`,
                `minerals`,
                `nature`
                ) 
            VALUES 
            ( 
                :c_id,  
                :a,
                :n,
                :nu,
                :mo,
                :ga,
                :mi,
                :na
            )"
        );
            $stmt->execute(["c_id"=>$ConsignmentOutData['crop'],"a"=>$ConsignmentOutData['amount'],"n"=>$ConsignmentOutData['name'],"nu"=>$ConsignmentOutData['number'],"mo"=>$ConsignmentOutData['moisture'],"ga"=>$ConsignmentOutData['garbage'],"mi"=>$ConsignmentOutData['minerals'],"na"=>$ConsignmentOutData['nature']]);

        $id = DB::getInstance()->connect->lastInsertId();
        $ConsignmentOut = new ConsignmentOut ($id, $ConsignmentOutData['crop'], $ConsignmentOutData['amount'], $ConsignmentOutData['name'], $ConsignmentOutData['number'], $ConsignmentOutData['moisture'], $ConsignmentOutData['garbage'], $ConsignmentOutData['minerals'], $ConsignmentOutData['nature']);

        $update = DB::getInstance()->connect->prepare("UPDATE `Crop` set `amount` = `amount` - :a WHERE `Crop`.`id` = :c_id");
            $update->execute(["c_id"=>$ConsignmentOutData['crop'],"a"=>$ConsignmentOutData['amount']]);

        return $ConsignmentOut;
    }


    public function update(): ConsignmentOut {
        //а редачить накладную не можно
    }

    public static function delete(int $id): void {
        $result = DB::getInstance()->connect->query("select `Consignment_OUT`.`id` AS `id`,`Consignment_OUT`.`Crop_id` AS `Crop_id`,`Crop`.`name` AS `crop_name`,`Consignment_OUT`.`amount` AS `amount`,`Consignment_OUT`.`date` AS `date`,`Consignment_OUT`.`name` AS `name`,`Consignment_OUT`.`number` AS `number`,`Consignment_OUT`.`moisture` AS `moisture`,`Consignment_OUT`.`garbage` AS `garbage`,`Consignment_OUT`.`minerals` AS `minerals`,`Consignment_OUT`.`nature` AS `nature` from (`Consignment_OUT` join `Crop` on((`Consignment_OUT`.`Crop_id` = `Crop`.`id`)))");
        $list = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach ($list as $k => $v){
            if ($v['id']==$id){
                $update = DB::getInstance()->connect->prepare("UPDATE `Crop` set `amount` = `amount` + :a WHERE `Crop`.`id` = :c_id");
                $update->execute(["c_id"=>$v['Crop_id'],"a"=>$v['amount']]);
                return null;
            }
        }

        $delete = DB::getInstance()->connect->prepare("DELETE from Consignment_OUT where id = :id");
        $delete->execute(["id"=>$id]);
    }

    public static function findById(int $id): ConsignmentOut {
        $stmt = DB::getInstance()->connect->prepare("SELECT * FROM `ConsignmentOut` WHERE `id`=:id");
        $stmt->execute(["id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $ConsignmentOut = new ConsignmentOut(
            $row['id'],
            $row['name'],
            $row['address'],
            $row['capacity']
        );

        return $ConsignmentOut;
    }

    public static function findAll(): array {
        $stmt = DB::getInstance()->connect->query("SELECT * FROM `ConsignmentOut`");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            return null;
        }
        $ConsignmentOuts = array();

        foreach ($results as $result) {
            $ConsignmentOut = new ConsignmentOut(
                $result['id'],
                $result['name'],
                $result['address'],
                $result['capacity']
            );
            $ConsignmentOuts[] = $ConsignmentOut;
        }

        return $ConsignmentOuts;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function getCropId(): int {
        return $this->cropId;
    }

    public function setCropId(int $cropId): void {
        $this->cropId = $cropId;
    }
    
    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getNumber(): string {
        return $this->number;
    }

    public function setNumber(string $number): void {
        $this->number = $number;
    }

    public function getMoisture(): float {
        return $this->moisture;
    }

    public function setMoisture(float $moisture): void {
        $this->moisture = $moisture;
    }

    public function getGarbage(): float {
        return $this->garbage;
    }

    public function setGarbage(float $garbage): void {
        $this->garbage = $garbage;
    }

    public function getMinerals(): float {
        return $this->minerals;
    }

    public function setMinerals(float $minerals): void {
        $this->minerals = $minerals;
    }

    public function getNature(): float {
        return $this->nature;
    }

    public function setNature(float $nature): void {
        $this->nature = $nature;
    }

}
?>