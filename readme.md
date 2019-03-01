# LMS for learning MEPhI "Algorithms Theory" course

This is the core project of [Learning Management System][mephi22] for learning [MEPhI][mephi] "Algorithms Theory" course. 
It includes most modules and provides integrations for separate modules.
This project based on [Laravel][lara] framework.

---

## Modules:
* **Administration** (navigation, statements, users management)
* **Testing** (training and control modes, questions and tests management)
* **Library** (lectures, books, materials for exam)
* **Emulators** (Turing, Markov, Post, RAM, Recursion)
* **Recognition** (student visitation control by phone built-in camera)
* **Generation and storage** (control protocols, statements, printable variants of tests)

---

### Administration
Administration module is accessible for admins, teachers and students. 
Admins and teachers can manage users and groups.
Students can only view personal account info.

Available functions:
* **Authentication** (registration, login, reset password)
* **Authorization** (available roles: Admin, Teacher, Student, Usual)
* **View and edit statements** (lectures, seminars, seminars activity, control works, resume)
* **Edit and verify users**
* **View personal account** (view course resume by sections)
* **Appoint teachers for groups** 
* **News management** (create, remove and hide news on the main page)
* **Add and archive groups**
* **Edit course plan**

---

### Testing
Testing module is created for passing tests by students and usual users and managing questions and tests by teachers.

Available test modes:
* **Training** - single-page test with fixed number of questions. Accessible for all registered users.
Result page shows percents of answers correctness and provides links to lectures in Library module if answers is wrong.
* **Control** - single-page test with fixed number of questions. Accessible for students if teacher has permitted.
Result page shows only total result and mark.
In background the result goes to statements.
* **Adaptive (beta)** - test with non fixed number of question. Every question is viewed on separate page.
Test uses adaptive question parameters: difficulty, discriminant, guess and adaptive student parameter: knowledge level.
Adaptive algorithm based on 13-Parameter Logistic Birnbaum Model and [Item Response Theory][irt].

Available question types:
* **One choice** - choose one radio button of several variants
* **Multi choice** - choose one or several checkboxes of several variants
* **Fill gaps** - fill gaps in statements. Each gap has list of variants.
* **Accordance table** - fill matrix of objects and their properties
* **Yes/No** - press 'yes' radio button if statement is true, 'no' otherwise
* **Definition** - write down the definition of the term (only for print)
* **Open type** - type the answer in special field
* **Theorem** - advance the title of the theorem and write down the evidence (only for print)
* **Three points** - compute function in three points
* **Task** - write down the solution (only for print)
* **From Kleene** - perform [Primitive Recursive Function][prf] in Kleene Basis

Available functions:
* **Pass tests**
* **Add, edit, find and archive questions**
* **Add, edit and archive tests**
* **Manage retests** (give retry for students to pass tests)
* **View test results**
* **View question info** (parameters and statistics)
* **View test info** (parameters and statistics)
* **Compute students knowledge level** (based on their result in previous courses)
* **Compute question adaptive parameters** (difficulty, discriminant, guess)

---

### Library
Library module is accessed for all registered users. In addition students can order books and teachers manage these orders.

Available functions:
* **Manage lectures** (create, edit, remove, view, download in doc and ppt)
* **Manage books for ordering** (create, edit, remove, order)
* **Download e-books**
* **Manage definitions** (create, edit, remove, view, download)
* **Manage theorems** (create, edit, remove, view, download)
* **Manage scientific materials** (create, edit, remove, view, download)
* **Manage scientists** (create, edit, remove, view)
* **View and download extra materials**

---

### Emulators
Emulators are created for improvement skills in programming. There are training and control mode like in Testing module.

Available emulators:
* [**Turing machine**][turing] (separate Java module. Available one-tape and three-tape)
* [**Markov algorithm**][markov] (separate Java module)
* [**Recursion**][prf] (separate Haskell module)
* [**Post–Turing machine**][post]
* [**Random-access machine**][ram]

Available functions:
* **Manage tasks** (Create, edit, remove)
* **Manage access for students** (only for control mode)
* **Manage retrying** (only for control mode)

---

### Recognition
Recognition module is created for help teachers control classes attendance by finding and identifying student's faces with device camera.
It is separate Swift module.

Available functions:
* **Link student's faces with users table**
* **Identify single student by face**
* **Identify group of student by faces**
* **Auto mark attendance in statements**

---

### Generation and Storage
Generation and storage module allows teachers to generate PDF versions of documents and to download generated files via browser.

Available documents:
* **Variants of tests**
* **Control test protocols with results**
* **Control emulator protocols with results**

---


[lara]: https://laravel.com
[mephi22]: http://mephi22.ru
[mephi]: https://mephi.ru
[irt]: https://en.wikipedia.org/wiki/Item_response_theory
[prf]: https://en.wikipedia.org/wiki/Primitive_recursive_function
[turing]: https://en.wikipedia.org/wiki/Turing_machine
[markov]: https://en.wikipedia.org/wiki/Markov_algorithm
[post]: https://en.wikipedia.org/wiki/Post%E2%80%93Turing_machine
[ram]: https://en.wikipedia.org/wiki/Random-access_machine

