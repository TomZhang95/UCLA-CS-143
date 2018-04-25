SELECT * FROM Movie; 
	-- Print the whole Movie table

SELECT id, last, first, sex, dob, dod
FROM Actor
WHERE dod IS NULL;
	-- Show all alive actors in the table

SELECT id, last, first
FROM Director
ORDER BY id
LIMIT 10;
	-- Show the id, last name, first name of 10 directors with smallest id number