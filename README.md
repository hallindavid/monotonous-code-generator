# Requirements

* php 7+
* apache (uses .htaccess file)
* write permissions on server/local machine

# Getting Started
* clone/download the repo
* place entire app into a web directory
* adjust configuration settings

# Configuration
in index.php you should find a few options which can be adjusted as desired

```
$GLOBALS['acceptable_extensions'] = array('csv');
//if a file is in the import folder, and it doesn't meet criteria, should the system delete it?
$GLOBALS['delete_bad_files'] = false;
//Output log on main page
$GLOBALS['log_output'] = true;
//The acceptable mimetypes for csv
$GLOBALS['accepted_mimetypes'] = array('text/csv','text/plain','application/csv','text/comma-separated-values','application/excel','application/vnd.ms-excel','application/vnd.msexcel','text/anytext','application/octet-stream','application/txt');
```
By default, we're looking to display the log, and really just take in CSV files.


If you set the `delete_bad_files` configuration option to true, the app will automatically delete files that are in the import folder, but aren't usable or don't match the accepted mime types/extensions. 

If you set it to false, the app will create a `rejected` folder in your import path, and move the file there.

# Usage
Once configuration is complete, browse to the domain/ip that you set this up in.

From here you should be able to upload a file, and when you do, it should appear in a list on the left hand side of the page.

If you click on one of those files, you will go to the process file page.

On the process file page, you are able to generate formatted text from your CSV file.

# Example Usages
Let's say you have a csv file with information such as the following.

| shortCode        | Status  	 |
|:----------|:----------|
| to_do    | To Do |
| in_progress    | In Progress |
| complete    | Complete |
| backlog    | Backlog |




**Basic Usage**

Now you want to get a database statement which is going to insert all of those (I know - it's not much when it's 4 rows, but this is just an example)

You could use the format
```
insert into blog_posts_statuses (short_code, status_description) VALUES('^1^','^2^');
```


This will produce an output that looks like this.

```
insert into blog_posts_statuses (short_code, status_description) VALUES('to_do','To Do');
insert into blog_posts_statuses (short_code, status_description) VALUES('in_progress','In Progress');
insert into blog_posts_statuses (short_code, status_description) VALUES('complete','Complete');
insert into blog_posts_statuses (short_code, status_description) VALUES('backlog','Backlog');
```
**Multi Line**
If you are creating a database seeding class, multi-line is A-OK.

```
blogPostStatus := &models.PostStatus{
	ShortCode:"^1^",
	Description: "^2^",
}
err = models.DB.Create(blogPostStatus)
if err != nil {
   panic(err)
}
```

This is a way to seed files through an ORM in GoBuffalo.
```
blogPostStatus := &models.PostStatus{
	ShortCode:"to_do",
	Description: "To Do",
}
err = models.DB.Create(blogPostStatus)
if err != nil {
   panic(err)
}
blogPostStatus := &models.PostStatus{
	ShortCode:"in_progress",
	Description: "In Progress",
}
err = models.DB.Create(blogPostStatus)
if err != nil {
   panic(err)
}
blogPostStatus := &models.PostStatus{
	ShortCode:"complete",
	Description: "Complete",
}
err = models.DB.Create(blogPostStatus)
if err != nil {
   panic(err)
}
blogPostStatus := &models.PostStatus{
	ShortCode:"backlog",
	Description: "Backlog",
}
err = models.DB.Create(blogPostStatus)
if err != nil {
   panic(err)
}

```


**Row Iteration**

Let's say we need to go a bit further, and we also need to have an ID column for this table.
You could use the format
```
insert into blog_posts_statuses (id, short_code, status_description) VALUES(^0^, '^1^','^2^');
```


This will produce an output that looks like this.

```
insert into blog_posts_statuses (id, short_code, status_description) VALUES(1, 'to_do','To Do');
insert into blog_posts_statuses (id, short_code, status_description) VALUES(2, 'in_progress','In Progress');
insert into blog_posts_statuses (id, short_code, status_description) VALUES(3, 'complete','Complete');
insert into blog_posts_statuses (id, short_code, status_description) VALUES(4, 'backlog','Backlog');
```



the `^0^` wildcard will place the row number into the outputted format.

# Notes on backend 
* We use the PHP class `SplFileObject` instead of just `fopen` so the scanning/preview/iterations are more efficient.
* Has a mini-router in the index.php file, and the htaccess file redirects all routes to index.php
* We define 2 classes in the backend
	* `Directory Scanner` - looks through the directory for files, removes files that aren't usable/acceptable
	* `File Scanner` - Checks file to ensure it's allowed, also performs formatting on the file for output
* These 2 classes were written as objects so that if anybody wants to, they could extend it as an outside library that can be imported into another project.
* We do go through some upload validation on the dropbox receiver 
* That said - I **WOULD NOT** recommend putting this anywhere other than localhost for development purposes - it's not secure enough by any means.


# Libraries Used
* Axios - https://github.com/axios/axios
* Bulma - https://bulma.io/
* Handlebars - https://handlebarsjs.com/
* Font Awesome - https://fontawesome.com/
* Dropzone - https://www.dropzonejs.com/
* Clipboardjs - https://clipboardjs.com/


# Contribution
I built this becuase I end up frequently having to do work like this - in Sublime text in many IDE's there are multi-line selection which does this really well for small batches of data, but when you get over 500 lines of code, it really starts choking up the machine.

I don't think I'm alone in the need for something like this, so if anybody wants to fork/branch this and build it out a bit, I'd be super happy to share the repo.

**Thanks!**

-David Hallin

