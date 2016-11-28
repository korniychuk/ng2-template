<?php
use ngt\Inflect;
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

/** @var boolean $isBaseRest */
$baseService = $cmd['base-rest'] ? 'BaseRestService' : 'DefaultRestService';

/** @var string $pluralNameCamelLower */
$pluralNameCamelLower = Inflect::pluralize($nameCamelLower);

/** @var string $pluralName */
$pluralName = Inflect::pluralize($name);

//
// 1. Make an api service
//
$tpl = <<<TPL
import { Injectable } from '@angular/core';

import { ${baseService}, RequestService } from 'app/modules/rest';
import { AnyObject, StringObject } from 'app/helpers/typed-object';

import { ${nameCamel} } from 'app/models/${name}.model';
import { config } from 'app/config';

/**
 * $nameCamel Api Service
 */
@Injectable()
export class ${nameCamel}ApiService extends ${baseService}<${nameCamel}> {
  protected baseUrl    = `\${config.apiBaseUrl}/${pluralName}`;
  protected pluralName = '${pluralNameCamelLower}';
  protected singleName = '${nameCamelLower}';
  protected modelClass = ${nameCamel};

  public constructor(
    request: RequestService,
  ) {
    super(request);
  }

  public makeModel(entity: AnyObject): ${nameCamel} {
    let mapped = this.map(entity);

    return new ${nameCamel}(mapped);
  } // end makeModel()

  public makeRawEntity(model: ${nameCamel}): AnyObject {
    let raw = this.map(model, true);

    return raw;
  } // end makeRawEntity()

  protected fieldsMap(): StringObject {
    return {
    };
  } // end fieldsMap()

}

TPL;
makeFile("$name-api.service.ts", $tpl);

//
// 2. Make a test for the service
//
$tpl = <<<TPL
/* tslint:disable:no-unused-variable */

import { TestBed, async, inject } from '@angular/core/testing';
import { Observable } from 'rxjs/Observable';
import { RequestService } from 'app/modules/rest';

import { {$nameCamel}ApiService } from './{$name}-api.service';


class TestRequestService {
  public path: string;
  public options: any;

  /**
   * Fill it before fire {@link TestRequestService.send}
   */
  public response: any;

  public send(path: string, options: any): Observable<any> {
    this.path    = path;
    this.options = options;

    return Observable.of(this.response);
  } // end send()

}


describe('Service: {$nameCamel}ApiService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [
        {$nameCamel}ApiService,
        {
          provide: RequestService,
          useClass: TestRequestService,
        },
      ],
    });
  });

  it('should ...', inject([{$nameCamel}ApiService], (service: {$nameCamel}ApiService) => {
    expect(service).toBeTruthy();
  }));
});

TPL;
makeFile("{$name}-api.service.spec.ts", $tpl);
