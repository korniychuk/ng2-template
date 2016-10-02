<?php
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

//
// 1. Create the pipe class
//
$tpl = <<<TPL
import { Pipe, PipeTransform } from '@angular/core';

/**
 * The pipe description ...
 
 * Usage:
 *   value | $nameCamelLower: 'argument'
 * Example:
 *   {{ 'input value' | highlight: 'argument' }}
 *   formats to: result value at here
 */
@Pipe({
  name: '$nameCamelLower',
})
export class {$nameCamel}Pipe implements PipeTransform {

  transform(value: any, args?: any): any {
    return null;
  }

}

TPL;
makeFile("$name.pipe.ts", $tpl);


//
// 2. Create a test for the pipe
//
$tpl = <<<TPL
/* tslint:disable:no-unused-variable */

import { TestBed, async } from '@angular/core/testing';
import { {$nameCamel}Pipe } from './$name.pipe';

describe('Pipe: {$nameCamel}Pipe', () => {
  let pipe: {$nameCamel}Pipe;

  it('create an instance', () => {
    let pipe = new {$nameCamel}Pipe();
    expect(pipe).toBeTruthy();
  });
  
  beforeEach(() => {
    pipe = new {$nameCamel}Pipe();
  });
  
  
  it('Should ... ', () => {
    let
        input  = '',
        output = null;
    expect(pipe.transform(input)).toEqual(output);
  });
});

TPL;
makeFile("$name.pipe.spec.ts", $tpl);
