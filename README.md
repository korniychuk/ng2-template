# Angular 2 CLI Templates

Creation main project elements with unit tests

## Installation
```bash
ln -s $(realpath ng-templator.php) ~/bin/ngt
chmod +x ~/bin/ngt
```

Notice: `~/bin` should be added to $PATH.

## Generating of blanks

- [Component](#component)
- [Small Component](#small-component)
- [Module](#module)
- [Directive](#directive)
- [Pipe](#pipe)
- [Service](#service)
- [Api Service](#api-service)
- [Model](#model)

---

### Component
```bash
$ ngt component my-component
```

Makes structure:

    .
    └───my-component
        ├───index.ts
        ├───my-component.component.pug
        ├───my-component.component.less
        ├───my-component.component.ts
        ├───my-component.component.spec.ts
        
Parameters:
- `-tp\--tag-prefix my` - (Note! without dash) makes prefix `my-` for component tag selector.  
  Default value is `app-`
- `-s\--style less` - generate styles in `.less` format instead of `.scss`


### Small Component
```bash
$ ngt small-component my-component
```

Makes component with inline styles and template

Makes structure:

    .
    ├───my-component.component.ts
    ├───my-component.component.spec.ts

Parameters:
- `-tp\--tag-prefix my` - (Note! without dash) makes prefix `my-` for component tag selector.  
  Default value is `app-`
- `-s\--style less` - generate styles in `.less` format instead of `.scss`


### Module
```bash
$ ngt module my-module
```

Makes structure:

    .
    └───my-module
        ├───index.ts
        ├───my-routes.module.ts

Parameters:
- `-wc\--with-component` - additionally makes main component for the module.  
    File structure:

        .
        └───my-module
            ├───index.ts
            ├───my-routes.module.ts
            ├───my-component.component.pug
            ├───my-component.component.less
            ├───my-component.component.ts
            ├───my-component.component.spec.ts

    Component parameters `-tp`, `-s` also available when you creates component with a module.  


### Directive
```bash
$ ngt directive super-highlight
```

Makes structure:

    .
    ├───super-highlight.directive.ts
    ├───super-highlight.directive.spec.ts

Parameters:
- `-sp\--selector-prefix my` (value without dash) makes prefix `my` for directive selector.  
  Result will be `mySuperHighlight`  
  Default value is `app`
  

### Pipe
```bash
$ ngt pipe pretty
```

Makes structure:

    .
    ├───pretty.pipe.ts
    ├───pretty.pipe.spec.ts


### Service
```bash
$ ngt service auth
```

Makes structure:

    .
    ├───auth.service.ts
    ├───auth.service.spec.ts


### Api Service
```bash
$ ngt api user
```

Makes structure:

    .
    ├───user-api.service.ts
    ├───user-api.service.spec.ts


### Model
```bash
$ ngt model user
```

Makes structure:

    .
    ├───user.model.ts
    ├───user.model.spec.ts
    
Parameters:
- `-f\--fields` makes fields for the model.  
  Available modifiers:
  - `s` - string (also default if not specified)
  - `b` - boolean
  - `n` - number
  - `a` - any
  - `MyClass` - custom type definition
  
  Every model has `id:n` field by default.  
  If you don't want to use `id` just specify field `-id` in fields. Example: `-f '-id'`.
  Notice: Specify `-id` as first column will not works.

  Example: `name;surname;email:s;age:n;isAdmin:b;currency:Currency;createdAt:a`
  Result will be
  - `user.model.ts`  
    Declarations:  
    ```
    public id: number;
    public name: string;
    public surname: string;
    public email: string;
    public age: number;
    public isAdmin: boolean;
    public currency: Currency;
    public createdAt: any;
    ```
    Initializations:
    ```
    this.id        = +data.id || null;
    this.name      = data.name || null;
    this.surname   = data.surname || null;
    this.email     = data.email || null;
    this.age       = +data.age || null;
    this.isAdmin   = data.isAdmin !== undefined && data.isAdmin !== null ? Boolean(data.isAdmin) : null;
    this.currency  = data.currency || null;
    this.createdAt = data.createdAt || null;
    ```
    Data in `.spec.ts`:
    ```
    id:         1,
    name:       'Test string 1',
    surname:    'Test string 2',
    email:      'Test string 3',
    age:        2,
    isAdmin:    true,
    currency:   'No generator. Using some string 1',
    createdAt:  'Any as string 1',
    ```
