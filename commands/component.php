<?php
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

/** @var string $styleExt */
$styleExt = $cmd['style'];

//
// 1. make dir
//
$dir = $name;
makeDir($dir);

//
// 2. make index.ts file
//
$tpl = "export * from './$name.component';";
makeFile($dir.'/index.ts', $tpl);

//
// 3. pug template
//
$tpl = "| $name";
makeFile($dir."/$name.component.pug", $tpl);

//
// 4. less|scss template
//
$tpl = <<<TPL
:host {

}

TPL;
makeFile($dir."/$name.component.$styleExt", $tpl);

//
// 5. The component
//
$tpl = <<<TPL
import { Component, OnInit } from '@angular/core';

@Component({
  selector:    '$name',
  template:    require('./$name.component.pug'),
  styleUrls:   ['./$name.component.$styleExt'],
})
export class {$nameCamel}Component implements OnInit {
  public constructor(
  ) {
  }

  public ngOnInit() {
  }

}
TPL;
makeFile($dir."/$name.component.ts", $tpl);

//
// 6. Unit-test
//
$tpl = <<<TPL
import { ActivatedRoute, Data } from '@angular/router';
import { Component } from '@angular/core';
import { inject, TestBed } from '@angular/core/testing';

// Load the implementations that should be tested
import { $nameCamel } from './$name.component';

class {$nameCamel}Mock extends $nameCamel {

}

describe('$nameCamel', () => {
  // provide our implementations or mocks to the dependency injector
  beforeEach(() => TestBed.configureTestingModule({
    providers: [
      {
        provide: $nameCamel,
        useClass: $nameCamel,
      },
      
    ]
  }));

  it('method ngOnInit() should exists', inject([$nameCamel], (unit: {$nameCamel}Mock) => {
    expect(typeof unit.ngOnInit).toEqual('function');
  }));

});
TPL;
makeFile($dir."/$name.component.spec.ts", $tpl);

