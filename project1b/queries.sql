-- Names of all the actors in the movie 'Die Another Day'
SELECT CONCAT(a.first,' ',a.last)
FROM Movie m, Actor a, MovieActor ma
WHERE title='Die Another Day' AND ma.mid=m.id AND ma.aid=a.id;

-- Count of all the actors who acted in multiple movies
SELECT COUNT(DISTINCT ma1.aid)
FROM MovieActor ma1, MovieActor ma2
WHERE ma1.aid=ma2.aid AND ma1.mid<>ma2.mid;

-- All the actors in all the movies directed by Christopher Nolan with no duplicates
SELECT DISTINCT CONCAT(a.first,' ',a.last) 
FROM Actor a, MovieActor ma, Director d, MovieDirector md 
WHERE d.id=md.did AND d.last='Nolan' AND d.first='Christopher' AND ma.mid=md.mid AND a.id=ma.aid;