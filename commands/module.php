<?php
/**
 * @author Anton Korniychuk <ancor.dev@gmail.com>
 *
 * @var string $name
 * @var string $nameCamel
 * @var string $nameCamelLower
 */

//
// 1. make dir
//
$dir = $name;
makeDir($dir);

//
// 2. Make module
//
$tpl = <<<TPL
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';

import { routes } from './$name.routes';

console.log('`$nameCamel` bundle loaded asynchronously');

@NgModule({
  declarations: [
    // Components / Directives/ Pipes
  ],
  imports: [
    CommonModule,
    FormsModule,
    RouterModule.forChild(routes),
  ]
})
export default class {$nameCamel}Module {
  static routes = routes;
}
TPL;
makeFile($dir."/index.ts", $tpl);

//
// 3. Make routes
//
$tpl = <<<TPL
import { ComponentName } from './component-name.component';

// async components must be named routes for WebpackAsyncRoute
export const routes = [
  { path: '', component: ComponentName, pathMatch: 'full' }
];
TPL;
makeFile($dir."/$name.routes.ts", $tpl);
