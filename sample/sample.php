<?php
$autoload = '../../../autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}
$class = '../src/Datagrid.php';
if (file_exists($class)) {
    require_once $class;
}

use Hoochicken\Datagrid\Datagrid;

$columns = ['id' => 'id', 'title' => 'Title', 'description' => 'Description', 'state' => 'State', ];
$data = [
    ['id' => '1', 'title' => 'Orange', 'description' => 'A color', 'state' => '1', ],
    ['id' => '2', 'title' => 'Red', 'description' => 'Another color', 'state' => '1', ],
    ['id' => '3', 'title' => 'Green', 'description' => 'Well, guess what', 'state' => '0', ],
    ['id' => '4', 'title' => 'WHite', 'description' => 'So, that#s NOT a color!', 'state' => '-1', ],
];

$datagridtable = new Datagrid();
echo $datagridtable->getTable($data, $columns);
