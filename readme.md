# ACF Bridge

A project that would integrate the Product variation inside the courses with ACF (Advanced Custom Fields). Currently, ACF does not provide support for adding fields on product variation, which is why we are create a bridge that would get the widgets inside the field of a certain ACF record and render it to the Product variation. We would then be the one to control and save this widgets.

This project aims to simplify adding of details inside the fields and removing the tasks from the developers.

## How to use




## How it works

**Main** - The main file contains the method that would start the integration.

**Factory** - considered as the brain that would point on what to build.

**Schema** - contains the raw object of a certain field group or field.

**Builder** - responsible for building and rendering the HTML of the widget. 