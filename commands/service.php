<?php
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

//
// 1. Make a service
//
$tpl = <<<TPL
import { Injectable } from '@angular/core';

/**
 * 
 */
@Injectable()
export class {$nameCamel}Service {

  constructor() {
  }

}

TPL;
makeFile("$name.service.ts", $tpl);

//
// 2. Make a test for the service
//
$tpl = <<<TPL
/* tslint:disable:no-unused-variable */

import { TestBed, async, inject } from '@angular/core/testing';
import { {$nameCamel}Service } from './$name.service';

describe('Service: {$nameCamel}', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [{$nameCamel}Service]
    });
  });

  it('should ...', inject([{$nameCamel}Service], (service: {$nameCamel}Service) => {
    expect(service).toBeTruthy();
  }));
});

TPL;
makeFile("$name.service.spec.ts", $tpl);
