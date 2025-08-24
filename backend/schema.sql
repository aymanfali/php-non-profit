-- create 'non_profit_org' database if not exists
CREATE DATABASE IF NOT EXISTS non_profit_org;

-- create 'users' table if not exists
CREATE TABLE
    IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- create 'impacts' table if not exists
CREATE TABLE
    IF NOT EXISTS impacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        image TEXT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- create 'news' table if not exists
CREATE TABLE
    IF NOT EXISTS news (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        image TEXT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- create 'contacts' table if not exists
CREATE TABLE
    IF NOT EXISTS contacts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- create 'about_us' table if not exists
CREATE TABLE
    IF NOT EXISTS about_us (
        id INT AUTO_INCREMENT PRIMARY KEY,
        our_history TEXT NULL,
        our_history_image TEXT NULL,
        our_values TEXT NULL,
        our_values_image TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

-- seeding data into database for testing
-- seeding fake users into 'users' table
-- default password for all current users is 'password'
INSERT INTO
    users (name, email, password, role)
VALUES
    (
        'admin',
        'admin@test.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'admin'
    ),
    (
        'John Doe',
        'john.doe@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Jane Smith',
        'jane.smith@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Peter Jones',
        'peter.jones@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Mary Williams',
        'mary.williams@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'David Brown',
        'david.brown@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Sarah Davis',
        'sarah.davis@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Michael Wilson',
        'michael.wilson@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Jennifer Taylor',
        'jennifer.taylor@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Richard Miller',
        'richard.miller@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Linda Moore',
        'linda.moore@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'James White',
        'james.white@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Patricia Thomas',
        'patricia.thomas@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Robert Jackson',
        'robert.jackson@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Elizabeth Harris',
        'elizabeth.harris@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Charles Martin',
        'charles.martin@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Susan Thompson',
        'susan.thompson@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Joseph Garcia',
        'joseph.garcia@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Jessica Martinez',
        'jessica.martinez@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Thomas Robinson',
        'thomas.robinson@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    ),
    (
        'Nancy Clark',
        'nancy.clark@example.com',
        '$2y$10$5DsXpcYuK40ZvcCMugFIsehuxHUEu./LR7c1.K1e.eOqLe0t4gR0S',
        'user'
    );

-- seeding fake impacts into 'impacts' table
INSERT INTO
    impacts (title, image, content)
VALUES
    (
        'Clean Water Project',
        'https://www.theregreview.org/wp-content/uploads/2019/02/GettyImages-904647396-4.33.40-PM.jpg',
        'Our project provided clean drinking water to over 1000 families in rural communities.'
    ),
    (
        'Education for All',
        'https://habitatbroward.org/wp-content/uploads/2020/01/10-Benefits-Showing-Why-Education-Is-Important-to-Our-Society.jpg',
        'We built and equipped a new school, giving 500 children access to quality education.'
    ),
    (
        'Healthcare Initiative',
        'https://nursesgroup.co.uk/assets/images/blog/healthcare-technology.jpg',
        'The new mobile clinic has delivered essential medical care to remote villages.'
    ),
    (
        'Food Security Program',
        'https://fpspi.org/wp-content/uploads/2024/03/food-security.jpg',
        'Our program has helped over 200 families with sustainable farming techniques.'
    ),
    (
        'Forest Restoration',
        'https://images.theconversation.com/files/487768/original/file-20221003-16-6g8bnw.jpg?ixlib=rb-4.1.0&rect=0%2C67%2C2048%2C1223&q=45&auto=format&w=926&fit=clip',
        'We planted 10,000 trees to restore local forests and protect wildlife habitats.'
    ),
    (
        'Youth Mentorship',
        'https://sparkcurriculum.org/wp-content/uploads/2024/01/Significance-of-Youth-Mentoring-Article-1080x675.webp',
        'Over 150 young people have been mentored, leading to higher employment rates.'
    ),
    (
        'Disaster Relief Fund',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-10/shutterstock_1677789109.jpg.webp?itok=L01eHyZn',
        'Provided immediate aid to communities affected by recent natural disasters.'
    ),
    (
        'Animal Shelter Renovation',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-02/PHOTO0000003416_0001.jpg.webp?itok=FiA3AyIo',
        'Renovated the local animal shelter, improving living conditions for rescued animals.'
    ),
    (
        'Skills Training Workshop',
        'https://habitatbroward.org/wp-content/uploads/2020/01/10-Benefits-Showing-Why-Education-Is-Important-to-Our-Society.jpg',
        'Held a series of workshops to teach vocational skills to unemployed adults.'
    ),
    (
        'Community Garden',
        'https://images.theconversation.com/files/487768/original/file-20221003-16-6g8bnw.jpg?ixlib=rb-4.1.0&rect=0%2C67%2C2048%2C1223&q=45&auto=format&w=926&fit=clip',
        'The new community garden is providing fresh produce for local residents.'
    ),
    (
        'Scholarship Program',
        'https://habitatbroward.org/wp-content/uploads/2020/01/10-Benefits-Showing-Why-Education-Is-Important-to-Our-Society.jpg',
        'Awarded 25 scholarships to deserving students from low-income backgrounds.'
    ),
    (
        'Art Therapy Classes',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-02/PHOTO0000003416_0001.jpg.webp?itok=FiA3AyIo',
        'Provided art therapy sessions for children recovering from traumatic experiences.'
    ),
    (
        'Elderly Care Program',
        'https://www.unesco.org/sites/default/files/styles/card_thumbnail/public/2021-11/pexels-min-an-1313814_1.jpg?itok=2t7D0KK_',
        'Our volunteers visit and assist elderly citizens in their homes.'
    ),
    (
        'Microloan Initiative',
        'https://www.unesco.org/sites/default/files/styles/banner_desktop/public/2025-02/hero-media_03.png.jpg.webp?itok=KoJj2-sM',
        'Helped 50 small businesses get started with microloans and business training.'
    ),
    (
        'Environmental Cleanup',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2025-07/txt-media_navigator_01.jpg.webp?itok=sAd4oVdL',
        'Organized a massive cleanup event for local rivers and parks.'
    ),
    (
        'Digital Literacy',
        'https://www.uil.unesco.org/sites/default/files/styles/small_fixed/article/2025-05/shutterstock_Gorodenkoff%20copy%205%20%281%29.jpg?itok=9sm_1szf&width=289&height=192',
        'Trained 300 individuals in essential computer and digital skills.'
    ),
    (
        'Domestic Violence Support',
        'https://www.unesco.org/sites/default/files/styles/thumb_pub_cover_large/public/unesdoc_medias/0000393250.png.jpg?itok=2ofa8B_x&width=205&height=290',
        'Offered safe housing and counseling to survivors of domestic violence.'
    ),
    (
        'Special Needs Support',
        'https://www.unesco.org/sites/default/files/styles/thumb_pub_cover_large/public/unesdoc_medias/0000394619.png.jpg?itok=hxwcpAIO&width=205&height=290',
        'Created a support group and resource center for families with special needs children.'
    ),
    (
        'Refugee Assistance',
        'https://www.unesco.org/sites/default/files/styles/small_fixed/article/2025-08/Rashid_Hamis_Malekela_Tanzania.jpg?itok=XhrYDSg1&width=289&height=192',
        'Provided housing, food, and legal aid to newly arrived refugees.'
    ),
    (
        'HIV/AIDS Awareness',
        'https://www.unesco.org/sites/default/files/styles/square_120/public/2024-02/global_observatory_610px.jpg?itok=7s2MT0P3',
        'Launched a campaign to raise awareness about HIV/AIDS prevention and treatment.'
    );

-- seeding fake news into 'news' table
INSERT INTO
    news (title, image, content)
VALUES
    (
        'Our Impact Report is Out',
        'https://sparkcurriculum.org/wp-content/uploads/2024/01/Significance-of-Youth-Mentoring-Article-1080x675.webp',
        'Read our latest report to learn about the incredible impact we had last year.'
    ),
    (
        'Community Workshop Series',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-10/shutterstock_1677789109.jpg.webp?itok=L01eHyZn',
        'Sign up for our free community workshops on topics like financial literacy and mental health.'
    ),
    (
        'Local Business Joins Our Mission',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-02/PHOTO0000003416_0001.jpg.webp?itok=FiA3AyIo',
        'A local bakery has committed to donating a portion of their profits to our cause.'
    ),
    (
        'New Website Launched',
        'https://habitatbroward.org/wp-content/uploads/2020/01/10-Benefits-Showing-Why-Education-Is-Important-to-Our-Society.jpg',
        'We are thrilled to announce the launch of our new and improved website!'
    ),
    (
        'Holiday Food Drive',
        'https://images.theconversation.com/files/487768/original/file-20221003-16-6g8bnw.jpg?ixlib=rb-4.1.0&rect=0%2C67%2C2048%2C1223&q=45&auto=format&w=926&fit=clip',
        'Help us make a difference this holiday season by donating to our annual food drive.'
    ),
    (
        'Annual Gala Raises $500,000',
        'https://www.theregreview.org/wp-content/uploads/2019/02/GettyImages-904647396-4.33.40-PM.jpg',
        'Our annual fundraising gala was a huge success, raising half a million dollars for our projects.'
    ),
    (
        'New Partnership with Tech Company',
        'https://habitatbroward.org/wp-content/uploads/2020/01/10-Benefits-Showing-Why-Education-Is-Important-to-Our-Society.jpg',
        'We are excited to announce a new partnership with a leading tech company to improve our operations.'
    ),
    (
        'Volunteer of the Year Announced',
        'https://nursesgroup.co.uk/assets/images/blog/healthcare-technology.jpg',
        'We celebrated our volunteers and named Maria Rodriguez as Volunteer of the Year.'
    ),
    (
        'Upcoming Marathon for a Cause',
        'https://fpspi.org/wp-content/uploads/2024/03/food-security.jpg',
        'Join us next month for our annual charity marathon to raise funds for local schools.'
    ),
    (
        'Grant Awarded for New Initiative',
        'https://images.theconversation.com/files/487768/original/file-20221003-16-6g8bnw.jpg?ixlib=rb-4.1.0&rect=0%2C67%2C2048%2C1223&q=45&auto=format&w=926&fit=clip',
        'We have been awarded a significant grant to launch our new youth empowerment initiative.'
    ),
    (
        'Environmental Policy Statement',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2025-07/txt-media_navigator_01.jpg.webp?itok=sAd4oVdL',
        'We have released our new environmental policy statement, detailing our commitment to sustainability.'
    ),
    (
        'Celebrating 10 Years of Service',
        'https://www.uil.unesco.org/sites/default/files/styles/small_fixed/article/2025-05/shutterstock_Gorodenkoff%20copy%205%20%281%29.jpg?itok=9sm_1szf&width=289&height=192',
        'We are celebrating our 10-year anniversary and looking back at a decade of impact.'
    ),
    (
        'New Book Drive for Libraries',
        'https://www.unesco.org/sites/default/files/styles/thumb_pub_cover_large/public/unesdoc_medias/0000393250.png.jpg?itok=2ofa8B_x&width=205&height=290',
        'Donate new or gently used books for our book drive to support local libraries.'
    ),
    (
        'Musical Benefit Concert',
        'https://www.unesco.org/sites/default/files/styles/thumb_pub_cover_large/public/unesdoc_medias/0000394619.png.jpg?itok=hxwcpAIO&width=205&height=290',
        'A local band is hosting a benefit concert to raise funds for our cause.'
    ),
    (
        'Mental Health First Aid Training',
        'https://www.unesco.org/sites/default/files/styles/small_fixed/article/2025-08/Rashid_Hamis_Malekela_Tanzania.jpg?itok=XhrYDSg1&width=289&height=192',
        'We are offering free mental health first aid training to community members.'
    ),
    (
        'Looking for Board Members',
        'https://www.unesco.org/sites/default/files/styles/square_120/public/2024-02/global_observatory_610px.jpg?itok=7s2MT0P3',
        'We are seeking passionate individuals to join our board of directors.'
    ),
    (
        'CEO Speaks at Global Conference',
        'https://habitatbroward.org/wp-content/uploads/2020/01/10-Benefits-Showing-Why-Education-Is-Important-to-Our-Society.jpg',
        'Our CEO gave a powerful speech on sustainable development at a recent conference.'
    ),
    (
        'Thank You to Our Sponsors',
        'https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-02/PHOTO0000003416_0001.jpg.webp?itok=FiA3AyIo',
        'We want to express our deepest gratitude to all of our corporate sponsors.'
    ),
    (
        'Success Story: Emily''s Journey',
        'https://www.unesco.org/sites/default/files/styles/card_thumbnail/public/2021-11/pexels-min-an-1313814_1.jpg?itok=2t7D0KK_',
        'Read about how our mentorship program transformed the life of a young woman named Emily.'
    ),
    (
        'Upcoming Volunteer Orientation',
        'https://www.unesco.org/sites/default/files/styles/banner_desktop/public/2025-02/hero-media_03.png.jpg.webp?itok=KoJj2-sM',
        'If you are interested in volunteering, join our next orientation session.'
    );

-- seeding fake contacts into 'contacts' table
INSERT INTO
    contacts (name, email, subject, message)
VALUES
    (
        'Alex Johnson',
        'alex.j@email.com',
        'Donation Inquiry',
        'I would like to know how to make a large donation.'
    ),
    (
        'Brenda Lee',
        'brenda.l@email.com',
        'Volunteer Opportunities',
        'I am interested in volunteering for your next project.'
    ),
    (
        'Chris Evans',
        'chris.e@email.com',
        'General Question',
        'Can you provide more information about your healthcare initiative?'
    ),
    (
        'Diana Rodriguez',
        'diana.r@email.com',
        'Partnership Proposal',
        'My company is interested in forming a corporate partnership.'
    ),
    (
        'Ethan Green',
        'ethan.g@email.com',
        'Website Feedback',
        'Your new website looks great! I found a small typo on the news page.'
    ),
    (
        'Fiona White',
        'fiona.w@email.com',
        'Event Details',
        'Could you send me more details about the upcoming marathon?'
    ),
    (
        'George Harris',
        'george.h@email.com',
        'Media Request',
        'I am a journalist and would like to interview your CEO.'
    ),
    (
        'Helen Clark',
        'helen.c@email.com',
        'Complaint',
        'I was disappointed with the lack of information on your site.'
    ),
    (
        'Ian Davis',
        'ian.d@email.com',
        'Success Story',
        'I wanted to share my personal success story thanks to your program.'
    ),
    (
        'Julia Brown',
        'julia.b@email.com',
        'Newsletter Signup',
        'Please add me to your monthly newsletter list.'
    ),
    (
        'Kevin Wilson',
        'kevin.w@email.com',
        'Technical Issue',
        'I am having trouble accessing my user account.'
    ),
    (
        'Laura Hall',
        'laura.h@email.com',
        'Sponsorship Inquiry',
        'What are the sponsorship levels for your annual gala?'
    ),
    (
        'Mark Thomas',
        'mark.t@email.com',
        'Donation Receipt',
        'I need a receipt for my recent donation.'
    ),
    (
        'Nancy Adams',
        'nancy.a@email.com',
        'Suggestion',
        'Have you considered a program for supporting single-parent families?'
    ),
    (
        'Oscar Perez',
        'oscar.p@email.com',
        'Speaking Engagement',
        'I would like to invite a representative to speak at our university.'
    ),
    (
        'Pamela Scott',
        'pamela.s@email.com',
        'Report Correction',
        'I believe there is an error in your latest impact report.'
    ),
    (
        'Quentin Baker',
        'quentin.b@email.com',
        'Career Opportunities',
        'Are you currently hiring for any positions?'
    ),
    (
        'Rachel King',
        'rachel.k@email.com',
        'Grant Information',
        'Can you provide details on how to apply for your grants?'
    ),
    (
        'Samuel Young',
        'samuel.y@email.com',
        'Thank You Note',
        'Just wanted to thank you for all the great work you do!'
    ),
    (
        'Tina Lopez',
        'tina.l@email.com',
        'General Feedback',
        'I love the new initiative on skills training.'
    );

-- seeding default data into 'about_us' table
INSERT INTO
    about_us (
        our_history,
        our_history_image,
        our_values,
        our_values_image
    )
VALUES
    (
        "UNESCO was created to decide what kind of society we wanted to build together after the destruction of two World Wars. As early as 1942, global leaders began imagining an organization that would use education, culture, science and information to build lasting peace. Over the years, UNESCO has implemented initiatives that have radically improved lives around the world, and shaped global action in its field of competence.",
        "https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2022-02/PHOTO0000003416_0001.jpg.webp?itok=FiA3AyIo",
        "Our #SharingHumanity campaign reminds us of our global values, culture, and knowledge. By strengthening these ties, we build the foundations of peace between people and nations.",
        "https://www.unesco.org/sites/default/files/styles/paragraph_medium_desktop/public/2024-11/txt-media_spread-word_brief.png.jpg.webp?itok=pm7WTfYR"
    );
