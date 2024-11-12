-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS sports_management;
USE sports_management;

-- Creat la tabla Teams
CREATE TABLE Teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),              
    city VARCHAR(100),            
    sport ENUM('Football', 'Basketball', 'Baseball', 'Other'),  
    foundation_date DATE,           
    UNIQUE (name, city)         
);

-- Crear la tabla Players
CREATE TABLE Players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,     
    number INT,                     
    team_id INT, 
    is_captain BOOLEAN DEFAULT FALSE, 
    FOREIGN KEY (team_id) REFERENCES Teams(id) ON DELETE CASCADE 
);

-- Insertar datos en la tabla de Equipos
INSERT INTO Teams (name, city, sport, foundation_date) VALUES
('FC Barcelona', 'Barcelona', 'Football', '1899-11-29'),
('Brooklyn Nets', 'Brooklyn', 'Basketball', '1967-06-01'),
('Real Madrid', 'Madrid', 'Football', '1902-03-06');

-- Insertar datos de ejemplo en la tabla de Jugadores
INSERT INTO Players (name, number, team_id, is_captain) VALUES
('Lionel Messi', 10, 1, TRUE),    
('Gerard Piqué', 3, 1, FALSE),    
('Sergio Busquets', 5, 1, FALSE), 
('Kevin Durant', 7, 2, TRUE),    
('Kyrie Irving', 11, 2, FALSE),   
('James Harden', 13, 2, FALSE),   
('Cristiano Ronaldo', 7, 3, TRUE), 
('Karim Benzema', 9, 3, FALSE),   
('Sergio Ramos', 4, 3, FALSE);  

