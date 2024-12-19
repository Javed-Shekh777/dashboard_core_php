DELIMITER//
	CREATE TRIGGER after_teacher_insert
    AFTER INSERT ON teacher
    FOR EACH ROW 
    BEGIN
    	INSERT INTO notification(operation,message) VALUES("INSERT",CONCAT("New Teacher added. ",NEW.teacherName));
    END;
    //
    CREATE TRIGGER after_teacher_update
    AFTER UPDATE ON teacher
    FOR EACH ROW 
    BEGIN
    	INSERT INTO notification(operation,message) VALUES("UPDATE",CONCAT("Teacher ",OLD.teacherName,' updated.' ));
    END;
    //
    CREATE TRIGGER after_teacher_delete
    AFTER DELETE ON teacher
    FOR EACH ROW 
    BEGIN
    	INSERT INTO notification(operation,message) VALUES("DELETE",CONCAT("Teacher ",OLD.teacherName,' deleted.'));
    END;
    //
DELIMITER    
    