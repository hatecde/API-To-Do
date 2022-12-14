
# REST API To-do application
## Sourses

### URL: http://maslov.softwars.com.ua/

# Functionality


## Get list of Tasks

### Request

`GET /tasks/`

### Response

    HTTP/1.1 200 OK
    
    {"id":3,"task_name":"cleaning","status_id":"1"}
    {"id":4,"task_name":"homework","status_id":"2"}
    {"id":5,"task_name":"watch something","status_id":"2"}
    
## Search by specific id 

### Request

`GET /tasks/3`

### Response

    HTTP/1.1 200 OK

    {"id":3,"task_name":"cleaning","status_id":"1"}

## Get Task with incorrect id 

### Request

`GET /tasks/1`

### Response

    HTTP/1.1 404
    Message : Task Not Found 
    
## Create new task     

### Request

`POST /tasks/ task_id := 3 task_name = writing`

### Response

    HTTP/1.1 message : task created
    Status: 201
    
## Update specific task     

### Request

`PATCH /tasks/1`
`task_id= 1 task_name= rest`

### Response

    HTTP/1.1 message : task updated
    Status: 200 
   
    
## Delete specific task  

### Request

`DELETE /tasks/4`

### Response

    HTTP/1.1 200 DELETE
    Message: Task 4 deleted
    Rows: 1

## Delete task without id   

### Request

`DELETE /tasks/`

### Response

    HTTP/1.1 Method not allowed
    Status: 405 
    
## Delete task with incorrect id   

### Request

`DELETE /tasks/12345`

### Response

    HTTP/1.1
    Status: 404 
    Message: Task not found 
    
## Usage of forbidden method    

### Request

`PUT /tasks/`

### Response

    HTTP/1.1 Method not allowed
    Status: 405 
      
 ## Example of work ErrorHandler  

### Request

`GET /tasks/`

### Response

    HTTP/1.1
    Status: 500 Internal Server Error
    code: 1045
    file: /home/kavapp/softwars.com.ua/maslov/src/Database.php
    line: 11
   
