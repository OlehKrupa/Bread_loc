<?php
class Standard {
    private const TABLE = "Standard";
    private int $id;
    private string $name;
    private int $minor_risk;
    private int $major_risk;
    private float $min_moisture;
    private float $max_moisture;
    private float $min_garbage;
    private float $max_garbage;
    private float $min_minerals;
    private float $max_minerals;
    private float $min_nature;
    private float $max_nature;

    public function __construct(int $id, string $name, int $minor_risk = 2, int $major_risk = 12, float $min_moisture, float $max_moisture, float $min_garbage, float $max_garbage, float $min_minerals, float $max_minerals, float $min_nature, float $max_nature) {
        $this->id = $id;
        $this->name = $name;
        $this->minor_risk = $minor_risk;
        $this->major_risk = $major_risk;
        $this->min_moisture = $min_moisture;
        $this->max_moisture = $max_moisture;
        $this->min_garbage = $min_garbage;
        $this->max_garbage = $max_garbage;
        $this->min_minerals = $min_minerals;
        $this->max_minerals = $max_minerals;
        $this->min_nature = $min_nature;
        $this->max_nature = $max_nature;
    }

    public static function create(array $StandardData) : Standard {
        $stmt = DB::getInstance()->connect->prepare("INSERT INTO `Standard` (
            `name`,
            `minor_risk`,
            `major_risk`,
            `min_moisture`,
            `max_moisture`,
            `min_garbage`,
            `max_garbage`,
            `min_minerals`,
            `max_minerals`,
            `min_nature`,
            `max_nature`
            ) 
        VALUES 
        ( 
            :n,  
            :min,
            :max,
            :min_mo,
            :max_mo,
            :min_ga,
            :max_ga,
            :min_mi,
            :max_mi,
            :min_na,
            :max_na
        )"
    );

        $stmt->execute(["n"=>$StandardData['name'],"min"=>$StandardData['minor_risk'],"max"=>$StandardData['major_risk'],"min_mo"=>$StandardData['min_moisture'],"max_mo"=>$StandardData['max_moisture'],"min_ga"=>$StandardData['min_garbage'],"max_ga"=>$StandardData['max_garbage'],"min_mi"=>$StandardData['min_minerals'],"max_mi"=>$StandardData['max_minerals'],"min_na"=>$StandardData['min_nature'],"max_na"=>$StandardData['max_nature']]);


        $id = DB::getInstance()->connect->lastInsertId();
        $Standard = new Standard ($id, $StandardData['name'], $StandardData['minor_risk'], $StandardData['major_risk'], $StandardData['min_moisture'], $StandardData['max_moisture'], $StandardData['min_garbage'], $StandardData['max_garbage'], $StandardData['min_minerals'], $StandardData['max_minerals'], $StandardData['min_nature'], $StandardData['max_nature']);

        return $Standard;
    }

    public function update(): Standard {
        $stmt = DB::getInstance()->connect->prepare("UPDATE `Standard`
            SET
            `name`=:n,
            `minor_risk`=:min,
            `major_risk`=:max,
            `min_moisture`=:min_mo,
            `max_moisture`=:max_mo,
            `min_garbage`=:min_ga,
            `max_garbage`=:max_ga,
            `min_minerals`=:min_mi,
            `max_minerals`=:max_mi,
            `min_nature`=:min_na,
            `max_nature`=:max_na
            where `id`=:id");
        $stmt->execute(["n"=>$this->name,"min"=>$this->minor_risk,"max"=>$this->major_risk,"min_mo"=>$this->name,"max_mo"=>$this->name,"min_ga"=>$this->name,"max_ga"=>$this->name,"min_mi"=>$this->min_minerals,"max_mi"=>$this->max_minerals,"min_na"=>$this->min_nature,"max_na"=>$this->max_nature,"id"=>$this->id]);

        return $this;
    }

    public static function delete(int $id): void {
        $result = DB::getInstance()->connect->query("select `Crop`.`Standard_id` AS `Standard_id` from (`Crop` join `Standard` on((`Crop`.`Standard_id` = `Standard`.`id`))) GROUP BY `Standard_id`");
        $list = $result->fetchAll(PDO::FETCH_ASSOC);

        foreach($list as $k => $v){
            if ($id==$v['Standard_id']){
                return null;
            } else {
                $delete = DB::getInstance()->connect->prepare("DELETE from Standard where id = :id");
                $delete->execute(["id"=>$id]);
            }
        }
    }

    public static function findById(int $id): Standard {
        $stmt = DB::getInstance()->connect->prepare("SELECT * FROM `Standard` WHERE `id`=:id");
        $stmt->execute(["id" => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $Standard = new Standard(
            $row['id'],
            $row['name'],
            $row['minor_risk'],
            $row['major_risk'],
            $row['min_moisture'],
            $row['max_moisture'],
            $row['min_garbage'],
            $row['max_garbage'],
            $row['min_minerals'],
            $row['max_minerals'],
            $row['min_nature'],
            $row['max_nature']
        );

        return $Standard;
    }

    public static function findAll(): array {
        $stmt = DB::getInstance()->connect->query("SELECT * FROM `Standard`");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $Standards = array();
        
        foreach ($results as $result) {
            $Standard = new Standard(
                $result['id'],
                $result['name'],
                $result['minor_risk'],
                $result['major_risk'],
                $result['min_moisture'],
                $result['max_moisture'],
                $result['min_garbage'],
                $result['max_garbage'],
                $result['min_minerals'],
                $result['max_minerals'],
                $result['min_nature'],
                $result['max_nature']
            );
            $Standards[] = $Standard;
        }
        return $Standards;
    }

    public function getId(): int {
        return $this->id;
    }
    
    public function setId(int $id): void {
        $this->id = $id;
    }
    
    public function getName(): string {
        return $this->name;
    }
    
    public function setName(string $name): void {
        $this->name = $name;
    }
    
    public function getMinorRisk(): int {
        return $this->minor_risk;
    }
    
    public function setMinorRisk(int $minor_risk): void {
        $this->minor_risk = $minor_risk;
    }
    
    public function getMajorRisk(): int {
        return $this->major_risk;
    }
    
    public function setMajorRisk(int $major_risk): void {
        $this->major_risk = $major_risk;
    }
    
    public function getMinMoisture(): float {
        return $this->min_moisture;
    }
    
    public function setMinMoisture(float $min_moisture): void {
        $this->min_moisture = $min_moisture;
    }
    
    public function getMaxMoisture(): float {
        return $this->max_moisture;
    }
    
    public function setMaxMoisture(float $max_moisture): void {
        $this->max_moisture = $max_moisture;
    }
    
    public function getMinGarbage(): float {
        return $this->min_garbage;
    }
    
    public function setMinGarbage(float $min_garbage): void {
        $this->min_garbage = $min_garbage;
    }
    
    public function getMaxGarbage(): float {
        return $this->max_garbage;
    }
    
    public function setMaxGarbage(float $max_garbage): void {
        $this->max_garbage = $max_garbage;
    }
    
    public function getMinMinerals(): float {
        return $this->min_minerals;
    }
    
    public function setMinMinerals(float $min_minerals): void {
        $this->min_minerals = $min_minerals;
    }
    
    public function getMaxMinerals(): float {
        return $this->max_minerals;
    }
    
    public function setMaxMinerals(float $max_minerals): void {
        $this->max_minerals = $max_minerals;
    }
    
    public function getMinNature(): float {
        return $this->min_nature;
    }
    
    public function setMinNature(float $min_nature): void {
        $this->min_nature = $min_nature;
    }
    
    public function getMaxNature(): float {
        return $this->max_nature;
    }
    
    public function setMaxNature(float $max_nature): void {
        $this->max_nature = $max_nature;
    }
}
?>