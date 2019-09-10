![ss1](./screen-shot1.png)

![ss3](./screen-shot3.gif) ![ss2](./screen-shot2.png)

### About

Message Broadcast System (MBS) เป็นระบบส่งข้อความ Broadcast ไปยังอุปกรณ์เคลื่อนที่ เช่น มือถือ ที่ติดตั้ง Line App

### Features

- ส่งข้อความ Broadcast ไปได้ที่ละหลายคน
- รองรับประเภท ข้อความ รูปภาพ วิดีโอ
- ผู้ใช้งานที่ เพิ่มเพื่อน และยืนยันตัวตนด้วย Code + วดป. เกิด แล้วเท่านั้น จึงจะสามารถรับข้อความ Broadcast ได้
- สามารถสร้างกลุ่มสำหรับผู้รับข้อความเฉพาะ
- สามารถเพิ่มผู้ใช้งานกลุ่มพิเศษ (ที่ไม่มี วดป. เกิด) เช่น Line ID ของหน่วยงาน หรือแผนกต่าง ๆ ภายในองค์กร
- ระบบจัดการผู้ใช้งานงานเบื้องต้น โดยสามารถ เพิ่ม แก้ไข ยกเลิกการผูก Line ID กับ ผู้ใช้งาน

### System Requirements
- Linux OS หรือ Windows server (ติดตั้ง ffmpeg package หากต้องการส่งข้อความประเภทวิดีโอ)
- MySQL 5.7+ หรือ MariaDB 10.2+
- Nginx หรือ Apache Server
- Git
- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Installation
ติดตั้งด้วย Docker
1. สร้างโปรเจคและ Docker Container
```sh
$ git clone https://github.com/rph-dev/mbs
$ cd mbs
$ chmod -R +x ./docker
$ cd docker
$ ./create.sh
```
##### แก้ไข .env
1.1 ส่วน Database connection
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_mbs
DB_USERNAME=root
DB_PASSWORD=root
```

1.2 ตั้งค่า Line Token (ขอ Token key ได้ที่ https://developers.line.biz/console)
```
LINE_MBS_CHANNEL_ACCESS_TOKEN="xxx"
LINE_MBS_CHANNEL_SECRET="xxx"
```

2. การติดตั้ง
```sh
$ ./install.sh
```

2.1 เข้าใช้งานผ่าน
```
http://127.0.0.1:8088
```
User ทดสอบ\
username: demo@email.com\
password: demo

2.2 กรณีต้องการ Stop service
```sh
$ ./stop.sh
```

2.3 กรณีต้องการ Start service
```sh
$ ./start.sh
```

2.4 กรณีต้องการลบ Docker Container
```sh
$ ./remove.sh
```

2.5 กรณีต้องการลบข้อมูลทั้งหมด
```sh
$ ./remove-data.sh
```

### Line Webhook (Development)
1. ตั้งค่า SSH tunnel (SSH port forwarding) สำหรับ SSL
```sh
$ ssh -R rph-line-bot:443:127.0.0.1:8088 serveo.net
```
ซึ่งจะได้ URL ตามตัวอย่างนี้ https://rph-line-bot.serveo.net

2. โดยระบบได้กำหมด Route ของ Webhook URL ไว้ดังนี้

https://rph-line-bot.serveo.net/api/line-bot/callback

*แนะนำให้ใช้ Webhook URL นี้สำหรับการทดสอบเท่านั้น โดยท่านสามารถนำ URL นี้ไปใช้ตั้งค่าสำหรับ Webhook Line Event ที่  https://developers.line.biz/console

### Bug Reports & Feature Requests
หากพบข้อผิดพาด (Programming bug) หรือคุณสมบัติอื่น ๆ ที่อยากเพิ่มเติมในอนาคต สามารถรายงานได้ที่ [GitHub Issues](https://github.com/rph-dev/mbs/issues)

### Upgrading
สามารถรันคำสั่งนี้เมื่อต้องการ Update ระบบ
```sh
$ ./update.sh
```

### Contributing
ระบบ Message Broadcast System (MBS) พัฒนาด้วย Laravel Framework 5.8 และ Vue.js หากท่านมองเห็นว่ามี Code ส่วนใดเหมาะสมที่ควรแก้ไข หรือปรับปรุงเพิ่มประสิทธิภาพให้ดีขึ้น ท่านสามารถ Fork โปรเจคนี้เพื่อส่ง Pull Requests เข้ามาได้ทุกเมื่อ

### Security Vulnerabilities

หากคุณค้นพบช่องโหว่ด้านความปลอดภัยภายใน Message Broadcast System (MBS) โปรดส่งอีเมลไปที่ Kongvut Sangkla ผ่านทาง [kongvut.s@rph.co.th](mailto:kongvut.s@rph.co.th) ช่องโหว่ความปลอดภัยทั้งหมดจะได้รับการแก้ไขทันที

### Credits
ฝ่ายเทคโนโลยีสารสนเทศ โรงพยาบาลราชพฤกษ์ Ratchaphruek Hospital Public Company Limited (RPH), Thailand

### License

The Message Broadcast System (MBS) is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
