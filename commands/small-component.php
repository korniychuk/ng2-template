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

/** @var string $tagPrefix */
$tagPrefix = $cmd['tag-prefix'];


//
// 1. The component
//
$tpl = <<<TPL
import { Component, OnInit } from '@angular/core';

@Component({
  selector: '{$tagPrefix}{$name}',
  
  template: `// [pug] //
  | $name
  // [/pug] //`,

  styles: [ `// [scss] //
  :host {

  }
  // [/scss] //` ],
})
export class {$nameCamel}Component implements OnInit {
  public constructor(
  ) {
  }

  public ngOnInit() {
  }

}

TPL;
makeFile("$name.component.ts", $tpl);


//
// 2. Unit-test
//
$tpl = <<<TPL
/* tslint:disable:no-unused-variable */

import { ComponentFixture, TestBed, async, inject, tick, fakeAsync } from '@angular/core/testing';
import { DebugElement, Component, Input, Output, EventEmitter } from '@angular/core';
import { By } from '@angular/platform-browser';

// Load the implementations that should be tested
import { {$nameCamel}Component } from './$name.component';

@Component({
  template: `
    <$tagPrefix-$name></$tagPrefix-$name>
  `,
})
class TestHostComponent {

}

describe('Component: $nameCamel', () => {
  let fixture: ComponentFixture<TestHostComponent>,
      comp: TestHostComponent,
      el: DebugElement;

  // provide our implementations or mocks to the dependency injector
  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [
        TestHostComponent,
        {$nameCamel}Component,
      ],
    });

    fixture = TestBed.createComponent(TestHostComponent);
    comp    = fixture.componentInstance;
    el      = fixture.debugElement;

    fixture.detectChanges();
  });

  it('Component element created successful', () => {
    let compEl = el.query(By.css('{$tagPrefix}-{$name}'));

    expect(compEl).toBeTruthy();
  });

});

TPL;
makeFile("$name.component.spec.ts", $tpl);


//
// 3. e2e test
//
