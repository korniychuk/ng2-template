<?php
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

//
// 1. Create the model class
//
$tpl = <<<TPL
import { Model } from 'app/core/model';

/**
 * $nameCamel Model
 */
export class $nameCamel extends Model<$nameCamel> {
  public id: number;

  /**
   * @inheritDoc
   */
  public constructor(data: any = {}) {
    super(data);

    this.id = +data.id || null;
  } // end constructor()

}

TPL;
makeFile("$name.model.ts", $tpl);


//
// 2. Create a test for the model
//
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
        id: 10,
    };

    let expectedModel: $nameCamel = Object.assign(Object.create($nameCamel.prototype), data, {
    });

    let model = new {$nameCamel}(data);
    expect(model).toEqual(expectedModel);
  });

});

TPL;
makeFile("$name.model.spec.ts", $tpl);
