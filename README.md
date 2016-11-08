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
- [Module](#module)
- [Directive](#directive)
- [Pipe](#pipe)
- [Service](#service)
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
$ ngt service user-api
```

Makes structure:

    .
    ├───user-api.service.ts
    ├───user-api.service.spec.ts


#### Model
```bash
$ ngt model user
```

Makes structure:

    .
    ├───user.model.ts
    ├───user.model.spec.ts
