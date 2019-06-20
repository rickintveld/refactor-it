# Refactor it!

### Requires

```bash
composer global require rintveld/refactor-it
```

### Updating
If you'd like to upgrade Refactor-it, simply execute:
```bash
composer global update
```


### Simple startup

When no refactor rules are present yet:

- `refactor-it init`; first time project init
 
 ### Project rules configuration
 
 You will be provided with a 

- ```private/refactor-it/rules.json``` Project based configuration

By default the rules.json will be filled with a set of refactoring rules. 
These rules will be used to refactor your code. You can add or remove rules from this file.
The rules can be found here -> https://cs.symfony.com/

Default set: **rules.json:**

```bash
{
    "ordered_class_elements": [
        "use_trait",
        "constant_public",
        "constant_protected",
        "constant_private",
        "property_public",
        "property_protected",
        "property_private",
        "construct",
        "destruct",
        "magic"
    ],
    "array_syntax": {
        "syntax": "short"
    },
    "concat_space": {
        "spacing": "one"
    },
    "phpdoc_trim": true,
    "phpdoc_order": true,
    "phpdoc_scalar": true,
    "phpdoc_types": true,
    "ordered_imports": true,
    "blank_line_before_return": true,
    "no_blank_lines_before_namespace": true,
    "no_blank_lines_after_phpdoc": true,
    "no_empty_phpdoc": true,
    "no_empty_statement": true,
    "no_mixed_echo_print": {
        "use": "echo"
    },
    "no_trailing_whitespace": true,
    "no_unused_imports": true,
    "no_whitespace_in_blank_line": true,
    "object_operator_without_whitespace": true,
    "function_typehint_space": true,
    "no_extra_consecutive_blank_lines": {
        "tokens": [
            "extra"
        ]
    },
    "phpdoc_add_missing_param_annotation": true,
    "is_null": true,
    "linebreak_after_opening_tag": true,
    "lowercase_cast": true,
    "@PSR2": true
}

```

### Available commands:
- **refactor-it init**                 *Sets the Refactor it rules*
- **refactor-it init --reset-rules**   *Resets the Refactor it rules*
- **refactor-it diff**                 *Syncs the files*

### Done
You can now use the command `refactor-it`

### PS
make sure you've got export PATH=~/.composer/vendor/bin:$PATH in you're .bash_profile :)