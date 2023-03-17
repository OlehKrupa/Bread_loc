<?php
class Crop {
    private const GRADES = ["Зіпсовано","Погано","Задовільно","Добре","Відмінно"];
    private const TABLE = "Crop";
    private int $id;
    private int $supplier_id;
    private string $date;
    private int $warehouse_id;
    private float $amount;
    private int $standard_id;
    private string $name;
    private string $variety;
    private string $grade;
    private float $moisture;
    private float $garbage;
    private float $minerals;
    private float $nature;

    public function __construct(int $id, int $supplier_id, string $date, int $warehouse_id, float $amount, int $standard_id, string $name, string $variety, string $grade, float $moisture, float $garbage, float $minerals, float $nature) {
        $this->id = $id;
        $this->supplier_id = $supplier_id;
        $this->date = $date;
        $this->warehouse_id = $warehouse_id;
        $this->amount = $amount;
        $this->standard_id = $standard_id;
        $this->name = $name;
        $this->variety = $variety;
        if ($this->checkGrade($grade)){
            $this->grade = $grade;
        }
        $this->moisture = $moisture;
        $this->garbage = $garbage;
        $this->minerals = $minerals;
        $this->nature = $nature;
    }

    public static function updateGrade(){
       //Тут складно, буде потім
    }

    public static function create(array $cropData) : Crop {
        $stmt = DB::getInstance()->connect->prepare("INSERT INTO `Crop` (
            `Supplier_id`,
            `date`,
            `Warehouse_id`,
            `amount`,
            `Standard_id`,
            `name`,
            `variety`,
            `moisture`,
            `garbage`,
            `minerals`,
            `nature`
            ) 
            VALUES 
            (
                :s_id,
                :dat,
                :w_id, 
                :a, 
                :st_id, 
                :n, 
                :v, 
                :m, 
                :g, 
                :mi, 
                :na
            )"
        );
        $stmt->execute([
            "s_id"=>$cropData['supplier_id'],
            "dat"=>$cropData['date'],
            "w_id"=>$cropData['warehouse_id'],
            "a"=>$cropData['amount'],
            "st_id"=>$cropData['standard_id'],
            "n"=>$cropData['name'],
            "v"=>$cropData['variety'],
            "m"=>$cropData['moisture'],
            "g"=>$cropData['garbage'],
            "mi"=>$cropData['minerals'],
            "na"=>$cropData['nature']
        ]);

        $id = DB::getInstance()->connect->lastInsertId();
        $crop = new Crop ($id, $cropData['supplier_id'], $cropData['date'], $cropData['warehouse_id'], $cropData['amount'], $cropData['standard_id'], $cropData['name'], $cropData['variety'], "Задовільно", $cropData['moisture'], $cropData['garbage'], $cropData['minerals'], $cropData['nature']);

        return $crop;
    }

    public function update(): Crop {
        $stmt = DB::getInstance()->connect->prepare("UPDATE `Crop`
            SET
            `Supplier_id`=:s_id,
            `date`=:dat,
            `Warehouse_id`=:w_id,
            `amount`=:a,
            `Standard_id`=:st_id,
            `name`=:n,
            `variety`=:v,
            `grade`=:gr,
            `moisture`=:m,
            `garbage`=:g,
            `minerals`=:mi,
            `nature`=:na
            where `id`=:id");
        $stmt->execute([
            "s_id"=>$this->supplier_id,
            "dat"=>$this->date,
            "w_id"=>$this->warehouse_id,
            "a"=>$this->amount,
            "st_id"=>$this->standard_id,
            "n"=>$this->name,
            "v"=>$this->variety,
            "gr"=>$this->grade,
            "m"=>$this->moisture,
            "g"=>$this->garbage,
            "mi"=>$this->minerals,
            "na"=>$this->nature,
            "id"=>$this->id
        ]);

        return $this;
    }

    public static function delete(int $id): void {
        $delete = DB::getInstance()->connect->prepare("DELETE from Crop where id = :id");
        $delete->execute(["id"=>$id]);
    }

    public static function findById(int $id): Crop {
        $stmt = DB::getInstance()->connect->prepare("SELECT * FROM `Crop` WHERE `id`=:id");
        $stmt->execute(["id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $crop = new Crop(
            $row['id'],
            $row['supplier_id'],
            $row['date'],
            $row['warehouse_id'],
            $row['amount'],
            $row['standard_id'],
            $row['name'],
            $row['variety'],
            $row['grade'],
            $row['moisture'],
            $row['garbage'],
            $row['minerals'],
            $row['nature']
        );
        return $crop;
    }

    public static function findAll(): array {
        $stmt = DB::getInstance()->connect->query("SELECT * FROM `crop`");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $crops = array();

        foreach ($results as $result) {
            $crop = new Crop(
                $result['id'],
                $result['supplier_id'],
                $result['date'],
                $result['warehouse_id'],
                $result['amount'],
                $result['standard_id'],
                $result['name'],
                $result['variety'],
                $result['grade'],
                $result['moisture'],
                $result['garbage'],
                $result['minerals'],
                $result['nature']
            );
            $crops[] = $crop;
        }

        return $crops;
    }

    private function checkGrade(string $grade): bool{
        if(!in_array($grade, self::GRADES)){
            throw new Exception("Оцінка неправильна");
        }
        return true;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getSupplierId(): int {
        return $this->supplier_id;
    }

    public function setSupplierId(int $supplier_id): void {
        $this->supplier_id = $supplier_id;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function setDate(string $date): void {
        $this->date = $date;
    }

    public function getWarehouseId(): int {
        return $this->warehouse_id;
    }

    public function setWarehouseId(int $warehouse_id): void {
        $this->warehouse_id = $warehouse_id;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function setAmount(float $amount): void {
        $this->amount = $amount;
    }

    public function getStandardId(): int {
        return $this->standard_id;
    }

    public function setStandardId(int $standard_id): void {
        $this->standard_id = $standard_id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getVariety(): string {
        return $this->variety;
    }

    public function setVariety(string $variety): void {
        $this->variety = $variety;
    }

    public function getGrade(): string {
        return $this->grade;
    }

    public function setGrade(string $grade): void {
        if (this->checkGrade($grade)){
            $this->grade = $grade;
        }
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