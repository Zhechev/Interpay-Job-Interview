Exercise from job interview for junior PHP position:

PHP test project:

There is a tree of start folder, it's subfolders, their subfolders, etc...
In each folder, subfolder, etc… there are same structured XML files stored. A sort of:

<book>
    <author>Isak Azimov</author>
    <name>End of spirit</name>
</book>
<book>
    <author>Ivan Ivanov</author>
    <name>Start of spirit</name>
</book>

1. Read XML parsed content into a data base table:
1.1. PHP script should read XML files information and add it to PostgreSQL database single table. The date of insertion should also be added. XML files content should be displayed as a result.
1.2. If a record from specified file and subfolder already exists PHP script has to update the date of the record and not to insert it as a new one. 

2. XML files should contain Cyrilic, Korean and Japanese symbols as well.

3. Create simple page with a search form (should search by author only from data base). Result should be printed right after search form.

4. Requirements: 
    - Use object oriented way of prorgamming
    - Write short description of test project
- Testing an unpredicted sutiations
- Use PostgreSQL for the database

