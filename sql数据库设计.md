CREATE TABLE Jinggubang(
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
url TEXT,
isVulnerable TINYINT UNSIGNED,
HttpMethod VARCHAR(20),
banner VARCHAR(50),
scanResult TEXT
)


CREATE TABLE Jinggubang(
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, #id
url TEXT,					#目标地址
isVulnerable TINYINT UNSIGNED,			#是否可注入
HttpMethod VARCHAR(20),				#注入点类型
banner VARCHAR(50),				#web服务banner信息
scanResult TEXT					#扫描结果
)
