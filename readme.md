# ACF Bridge

A project that would integrate the Product variation inside the courses with ACF (Advanced Custom Fields). Currently, ACF does not provide support for adding fields on product variation, which is why we are create a bridge that would get the widgets inside the field of a certain ACF record and render it to the Product variation. We would then be the one to control and save this widgets.

This project aims to simplify adding of details inside the fields and removing the tasks from the developers.

## How to use


### Instantiate the Integration
> already called inside the other methods, so we don't need to call it when calling a certain method below
```
CourseACFIntegration::init();
```

### Output the Field Group

Set the field group inside the integration, then call on the `render()` function to show the output
`$fieldGroupID`
: The ID of a specific field group in ACF
```
CourseACFIntegration::setFieldGroup( $fieldGroupID )->render();
```

### Output a Field

Set the field inside the integration, then call on `render()` function to show the field's HTML

`$fieldID`
: The ID of a specific field in ACF
```
CourseACFIntegration::setFieldId( $fieldID )->render();
```

### Add support for loops

The loop support should be added when adding the integration inside a loop,

> This adds the array `[]` to the ID and Name

`$ctr`
: The index that would be added to the name and id field *Ex: name="name-test[0]"*
 > Defaults index is 0
```
// Field Group looping support
CourseACFIntegration::setFieldGroup( $fieldGroupID )->addLoopingSupport( $ctr = 0 )->render();

// Field looping support
CourseACFIntegration::setFieldId( $fieldID )->addLoopingSupport( $ctr = 0 )->render();
```

### Add or Set parent HTML class

`$class` 
: The html class that would be added to the parent HTML of the output 


```
// Field Group looping support
CourseACFIntegration::setFieldGroup( $fieldGroupID )->addParentHtmlClass( $class )->render();

// Field looping support with class
// -------------------------------------------
// The set method should be used inside a loop, 
// since the class would add up per loop instead of a single clas
// inside the parent class
CourseACFIntegration::setFieldId( $fieldID )->addLoopingSupport( $ctr = 0 )->setParentHtmlClass( $class )->render();
```

### Add Data attributes to the HTML

`$key` 
: The key to the data attribute *Ex: data-{$key}*

`$value` 
: The value given to the data attribute *Ex: data-{$key}="{$value}" 

 
```
// Add a single data attribute to the parent html
CourseACFIntegration::setFieldGroup( $fieldGroupID )->addDataAttribute( $key, $value )->render();

// Add multiple data attribute to the parent html
CourseACFIntegration::setFieldId( $fieldID )
                      ->addDataAttribute( $key1, $value1 )
                      ->addDataAttribute( $key2, $value2 )
                      ->render();
                      
// or pass it via an array
$dataAttributes = [
                    "key1" => "value1",
                    "key2" => "value2",
                  ]
CourseACFIntegration::setFieldGroup( $fieldGroupID )->addDataAttribute( $dataAttributes )->render();
```


## How it works

**Main** - The main file contains the method that would start the integration.

**Factory** - considered as the brain that would point on what to build.

**Schema** - contains the raw object of a certain field group or field.

**Builder** - responsible for building and rendering the HTML of the widget. 

`Main` --- calls --> `Factory` -- gets --> `Schema` -- pass data --> `Builder`