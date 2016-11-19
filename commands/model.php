<?php
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

/** @var string $fields */
$fieldsStr = $cmd['fields'];

//
// 0. Parsing fields
//
$fields = ['id' => 'number'];
$typesMap = [
    's' => 'string',
    'n' => 'number',
    'b' => 'boolean',
    'a' => 'any',
];
if ($fieldsStr) {
    if (!preg_match('/^(([\w]+)(?::(\w))?)(?:;(?1))*$/', $fieldsStr)) {
        throw new Exception('Incorrect fields format');
    }

    foreach(explode(';', $fieldsStr) as $key => $field) {
        $details = explode(':', $field);
        $fieldName = $details[0];
        $fieldType = isset($details[1]) ? $details[1] : null;
        $fields[$fieldName] = $fieldType ? $typesMap[$fieldType] : 'string';
    }
}


//
// 1. Create the model class
//
$declarations    = [];
$initializations = [];
$parserMap = [
    'string'  => function ($name) { return "data.$name || null"; },
    'number'  => function ($name) { return "+data.$name || null"; },
    'boolean' => function ($name) { return "data.$name !== undefined && data.$name !== null ? Boolean(data.$name) : null"; },
    'any'     => function ($name) { return "data.$name || null"; },
];
$maxLength = array_reduce(array_keys($fields), function($len, $b) { return $len >= strlen($b) ? $len : strlen($b); }, 0);
foreach($fields as $fName => $fType) {
    $declarations[] = "  public $fName: $fType;";

    $fNameSpaced       = str_pad($fName, $maxLength);
    $valueExtractor    = $parserMap[$fType]($fName);
    $initializations[] = "    this.$fNameSpaced = $valueExtractor;";
}
$declarations    = implode("\n", $declarations);
$initializations = implode("\n", $initializations);
$tpl = <<<TPL
import { Model } from 'app/helpers/model';

/**
 * $nameCamel Model
 */
export class $nameCamel extends Model<$nameCamel> {
{$declarations}

  /**
   * @inheritDoc
   */
  public constructor(data: any = {}) {
    super(data);

{$initializations}
  } // end constructor()

}

TPL;
makeFile("$name.model.ts", $tpl);


//
// 2. Create a test for the model
//
$generatorMap = [
    'string'  => function() { static $num = 1; return "'Test string ".$num++."'"; },
    'number'  => function() { static $num = 1; return $num++; },
    'boolean' => function() { static $num = 1; return ($num++)%2 ? 'true' : 'false'; },
    'any'     => function() { static $num = 1; return "'Any as string ".$num++."'"; },
];
$data = [];
foreach ($fields as $fName => $fType) {
    $nameAndColumn = str_pad($fName.':', $maxLength+1);
    $value = isset($generatorMap[$fType]) ? $generatorMap[$fType]() : "'No generator'";
    $data[] = "      $nameAndColumn $value,";
}
$data = implode("\n", $data);
$tpl = <<<TPL
/* tslint:disable:no-unused-variable */

import { {$nameCamel} } from './$name.model';

describe('Model: $nameCamel', () => {

  it('should create an instance without data', () => {
    let model = new {$nameCamel}();
    expect(model).toBeTruthy();
  });

  it('should create an instance with initial data', () => {
    let data: any = {
{$data}
    };

    let expectedModel: $nameCamel = Object.assign(Object.create($nameCamel.prototype), data, {
    });

    let model = new {$nameCamel}(data);
    expect(model).toEqual(expectedModel);
  });

});

TPL;
makeFile("$name.model.spec.ts", $tpl);
