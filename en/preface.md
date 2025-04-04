# Preface

## Acknowledgments
This manual is dedicated to everyone who, through their time and support (whether large or small), has helped this
framework improve day by day. To the entire KumbiaPHP community, with their questions, bug reports, contributions, and
critiques—thank you all!

## About This Manual
The KumbiaPHP book aims to demonstrate how this framework can assist in a developer's daily work. It shows different
aspects of KumbiaPHP and explains why it might be the tool you have been waiting for to begin your project. It is under
continuous development (graphic design, spelling and grammar review, content updates, etc.), just like the framework
itself, so it is recommended to always use the latest version.

This manual’s current edition has undergone significant changes compared to the previous one. Thanks to community
feedback, recurring questions were identified in the group, the forum, and the chat. In addition, improper use of the
MVC pattern and underutilization of Object-Oriented Programming (OOP) capabilities were detected. This edition strives
to address these aspects and improve usage clarity, allowing for the creation of more maintainable, higher-quality
applications.

## About KumbiaPHP
KumbiaPHP is a Latin product made for the world. Programming should be as enjoyable as dancing, and KumbiaPHP makes
coding as pleasant as dancing. It is a free-to-use framework under the New BSD license, so you can use it in your
projects as long as you respect the terms of that license. It is recommended to always use stable and recent versions,
as they include fixes, new features, and notable improvements.

## About the Community
The KumbiaPHP community originally emerged from Spanish-speaking developers, giving rise to a framework that was
entirely in Spanish. However, there is now an English-speaking community as well, contributing to KumbiaPHP’s
international expansion. Over time, various communication channels have been implemented, including a mailing list, a
forum, an IRC channel, a Wiki, and most recently, a Slack workspace, which is the most convenient way to get support and
interact with other users. This collaborative effort makes the community essential for enhancing and improving KumbiaPHP.  
For more information, visit the [Official KumbiaPHP Website](https://www.kumbiaphp.com).

## Why Use KumbiaPHP Framework?
Many people ask questions such as: how does this framework work, is it just another one, is it easy, how powerful is it,
and so on. Below are some reasons to use KumbiaPHP:

- It is very easy to use (Zero-Config). Starting with KumbiaPHP is extremely simple: just decompress it and begin
  working. This philosophy is also known as “Convention over Configuration.”
- It speeds up development. Creating a very functional application with KumbiaPHP can take only minutes or hours,
  allowing you to satisfy client needs without using excessive time. With its numerous tools, you can accomplish more in
  less time.
- It separates business logic from presentation. One of the best web development practices is to separate data logic
  from presentation. With KumbiaPHP, implementing the MVC (Model, View, Controller) pattern is straightforward, which
  makes applications easier to maintain and scale.
- It reduces the use of other languages. Thanks to Helpers and patterns like ActiveRecord, it minimizes the need to
  write HTML and SQL (even if only to a lesser extent). KumbiaPHP handles these tasks, resulting in clearer, more
  natural code that is less prone to errors.
- It speaks English (and also Spanish, with more languages to come)!  
  KumbiaPHP originally offered documentation, error messages, and configuration files in Spanish, but an
  internationalization (i18n) system is gradually being introduced to provide multilingual support and reach an even
  broader global audience.
- Its learning curve is very short, especially for those who already have experience with Object-Oriented Programming.
- It feels like a game. Without realizing it, you apply multiple design patterns that simplify work by providing
  abstraction, reducing code, and making the application easier to understand. Working with KumbiaPHP means naturally
  applying many patterns.
- It is Free Software. There is no need to worry about extra licensing, and KumbiaPHP encourages learning communities,
  where knowledge is shared by everyone, and each person decides how best to use it.
- It enables the creation of robust applications. Today’s applications require solid architectures. KumbiaPHP provides
  an architecture that is easy to learn and implement, without overcomplicating concepts or sacrificing quality.

## What Does KumbiaPHP Provide?
KumbiaPHP is an effort to produce a framework that reduces the time needed to develop a web application without
negatively affecting programmers, based on key principles we always keep in mind:

- KISS (“Keep It Simple, Stupid”).  
- DRY (“Don’t Repeat Yourself,” also known as “Once and Only Once”).  
- Convention over Configuration.  
- Speed.

In addition, KumbiaPHP is based on the following premises:

- Easy to learn.  
- Easy to install and configure.  
- Compatible with many platforms.  
- Ready for commercial applications.  
- Simple in most cases but flexible enough for more complex scenarios.  
- Support for numerous features in modern web applications.  
- Application of productive and efficient programming practices and patterns.  
- Creation of applications that are easy to maintain.  
- Based on Free Software.

The main goal is to create applications that are practical for the end user and not just for the programmer. Most tasks
that consume the developer’s time should be automated by KumbiaPHP, allowing focus on the application’s business logic.
You should not have to reinvent the wheel every time you start a new software project.

To achieve these objectives, KumbiaPHP is written in PHP5 (fully compatible with PHP 8.0) and has been tested in
real-world applications spanning various sectors with different demands and functionalities. It is compatible with the
most commonly used databases today:

- MySQL  
- PostgreSQL  
- Oracle  
- SQLite  

KumbiaPHP’s object model is applied in the following layers:

- [Application Logic](model.md)  
- [Database Abstraction and Object-Relational Mapping](active-record.md)  

Common features of web applications that KumbiaPHP automates include:

- Templates (TemplateView).  
- Form validation and persistence.  
- Cache management.  
- Scaffolding.  
- Front Controller.  
- AJAX interaction.  
- Form generation.  
- Security.  
