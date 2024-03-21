<?php

// Abstract class Person
abstract class Person {
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    abstract public function role();

    public function getName() {
        return $this->name;
    }
}

// Student class extends Person
class Student extends Person {
    private $group;
    private $paid;

    public function __construct($name, $group) {
        parent::__construct($name);
        $this->group = $group;
        $this->paid = false;
    }

    public function role() {
        return "Student";
    }

    public function getGroup() {
        return $this->group;
    }

    public function hasPaid() {
        return $this->paid;
    }

    public function setPaid($paid) {
        $this->paid = $paid;
    }
}

// Group class
class Group {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}

// Teacher class extends Person
class Teacher extends Person {
    private $salary;

    public function __construct($name, $salary) {
        parent::__construct($name);
        $this->salary = $salary;
    }

    public function role() {
        return "Teacher";
    }

    public function getSalary() {
        return $this->salary;
    }
}

// SchooltripList class
class SchooltripList {
    private $studentList = [];
    private $teacher;

    public function addStudentToList(Student $student) {
        $this->studentList[] = $student;
    }

    public function setTeacher(Teacher $teacher) {
        $this->teacher = $teacher;
    }

    public function getStudentLists() {
        return $this->studentList;
    }

    public function getTeacher() {
        return $this->teacher;
    }
}

// Schooltrip class
class Schooltrip {
    private $name;
    private $schooltripLists = [];
    private $countStudent = 0;
    private $countList = 0;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addSchooltripList(SchooltripList $list) {
        $this->schooltripLists[] = $list;
        $this->countList++;
    }

    public function addStudent(Student $student) {
        $this->countStudent++;
        $listIndex = $this->countList - 1;
        if ($listIndex < 0) $listIndex = 0; // Ensuring we have at least one list
        $this->schooltripLists[$listIndex]->addStudentToList($student);
    }

    public function getSchooltripLists() {
        return $this->schooltripLists;
    }

    public function getName() {
        return $this->name;
    }
}

// Testgegevens
$group1 = new Group("Class A");
$group2 = new Group("Class B");

$teacher1 = new Teacher("Koningstein", 50000);
$teacher2 = new Teacher("Brugge", 55000);

$schooltrip = new Schooltrip("Pretpark Trip");

$studentNames1 = ["Piet", "Jan", "Kees", "Klaas", "Mohammed"];
$studentNames2 = ["Eefje", "Pieter", "Martijn", "Mark", "Johan"];

// Toevoegen van leerlingen aan de leraren
for ($i = 0; $i < 5; $i++) {
    $student = new Student($studentNames1[$i], $group1);
    if ($i < 3) $student->setPaid(true); // Markeer enkele studenten als betaald
    $schooltripList1 = new SchooltripList();
    $schooltripList1->setTeacher($teacher1);
    $schooltripList1->addStudentToList($student);
    $schooltrip->addSchooltripList($schooltripList1);
}

for ($i = 0; $i < 5; $i++) {
    $student = new Student($studentNames2[$i], $group2);
    if ($i % 2 == 0) $student->setPaid(true); // Markeer enkele studenten als betaald
    $schooltripList2 = new SchooltripList();
    $schooltripList2->setTeacher($teacher2);
    $schooltripList2->addStudentToList($student);
    $schooltrip->addSchooltripList($schooltripList2);
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Trip</title>
    <style>
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>Docent</th>
        <th>Student</th>
        <th>Klas</th>
        <th>Betaald</th>
    </tr>
    <?php foreach ($schooltrip->getSchooltripLists() as $list): ?>
        <?php $teacher = $list->getTeacher(); ?>
        <?php $studentLists = $list->getStudentLists(); ?>
        <?php foreach ($studentLists as $index => $student): ?>
            <?php $group = $student->getGroup(); ?>
            <tr>
                <?php if ($index === 0): ?>
                    <td rowspan="<?php echo count($studentLists); ?>"><?php echo $teacher->getName(); ?></td>
                <?php endif; ?>
                <td><?php echo $student->getName(); ?></td>
                <td><?php echo $group->getName(); ?></td>
                <td><?php echo ($student->hasPaid()) ? 'Ja' : 'Nee'; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
</table>

</body>
</html>