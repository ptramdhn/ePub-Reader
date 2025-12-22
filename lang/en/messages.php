<?php

return [
    // --- AUTHENTICATION (Existing) ---
    'login_btn'         => 'Login',
    'login_title'       => 'Sign in to your account',
    'register_title'    => 'Create New Account',
    'no_account'        => 'Don\'t have an account?',
    'have_account'      => 'Already have an account?',
    'register_link'     => 'Register now',
    'login_link'        => 'Login here',
    'email_label'       => 'Campus Email',
    'password_label'    => 'Password',
    'name_label'        => 'Full Name',
    'confirm_password'  => 'Confirm Password',
    'login_button'      => 'Sign In',
    'register_button'   => 'Sign Up',
    'fst_slogan'        => 'Integrated Digital Reading Platform',
    'fst_join'          => 'Join With Us',
    'fst_desc'          => 'Access thousands of academic literature in one hand.',
    'back_home'         => 'Back to Home',

    // --- LANDING PAGE: NAVBAR ---
    'nav' => [
        'search_placeholder' => 'Search books, thesis, or journals...',
        'account'            => 'Account',
        'login'              => 'Log in',
        'register'           => 'Register',
        'account' => 'Account',
        'logout' => 'Logout',
    ],

    // --- LANDING PAGE: HERO SECTION ---
    'hero' => [
        'title_1'    => 'Digital Library',
        'title_2'    => 'Faculty of Science & Technology',
        'desc'       => 'Find the best collection of textbooks, journals, and scientific papers to support your studies. Easy access anywhere, anytime.',
        'cta_read'   => 'Start Reading',
        'cta_upload' => 'Upload Work',
    ],

    // --- LANDING PAGE: RECOMMENDED SECTION ---
    'rec' => [
        'title'        => 'Recommended Right Now',
        'card1_title'  => 'THE NOTABLE AND AWARD-WINNING RESEARCH',
        'card1_desc'   => 'A collection of lecturer journals and student theses from FST that successfully penetrated international Scopus-indexed publications this year.',
        'card2_title'  => 'ESSENTIAL TEXTBOOKS FOR THIS SEMESTER',
        'card2_desc'   => 'Prepare for the odd semester lectures with a collection of mandatory textbooks and practicum modules curated by the study program.',
    ],

    // --- LANDING PAGE: FEATURED (BIG IMAGE) ---
    'feat' => [
        'badge'    => 'The Year in Research 2025',
        'share'    => 'SHARE',
        'the'      => 'THE',
        'knowledge' => 'KNOWLEDGE',
        'subhead'  => 'Discover the <br> <span class="font-bold text-uin-blue dark:text-uin-yellow">Biggest Books of 2025</span>',
        'desc'     => 'Share the magic of literacy with fellow students! Explore the best theses, accredited journals, and lecturer-selected textbooks for this semester.',
        'cta'      => 'See The List',
    ],

    // --- LANDING PAGE: TOP BOOKS ---
    'top' => [
        'title' => 'LATEST <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-uin-blue to-uin-green">UPLOADS</span>',
        'cta_chart'  => 'VIEW CHART',
        'view_all'   => 'View All',
        // Dummy Data Titles (Optional, usually from DB)
        'book1'      => 'Intro to Molecular Biology',
        'book2'      => 'Algorithms & Data Structures',
        'book3'      => 'Advanced Calculus II',
    ],

    // --- LANDING PAGE: CATEGORIES ---
    'cat' => [
        'title'   => 'Collection Categories',
        'names'   => [
            'ti'  => 'Informatics',
            'si'  => 'Information Systems',
            'mtk' => 'Mathematics',
            'bio' => 'Biology',
            'fis' => 'Physics',
            'kim' => 'Chemistry',
        ],
        'explore' => 'Explore More Categories',
    ],

    // --- LANDING PAGE: BOTTOM CTA ---
    'bottom' => [
        'title_1' => 'Ready to start?',
        'title_2' => 'Publish in FST Repository.',
        'desc'    => 'Join thousands of other FST students and lecturers. Share your scientific work and expand your academic reach today.',
        'cta'     => 'Upload Now',
    ],

    // --- LANDING PAGE: FOOTER ---
    'footer' => [
        'team'        => 'Our Team',
        'news'        => 'FST News',
        'community'   => 'Community',
        'help'        => 'Help',
        'devs'        => 'Developers',
        'news_title'  => 'Get Latest FST Tips & Info',
        'news_desc'   => 'Subscribe to the newsletter for new journals and books info. You can unsubscribe anytime.',
        'news_place'  => 'Student/Lecturer Email...',
        'subscribe'   => 'Subscribe',
        'privacy'     => 'Privacy Policy',
        'terms'       => 'Terms & Conditions',
        'security'    => 'Security',
        'copyright'   => 'Copyright © 2025 Faculty of Science and Technology UIN Jakarta. All rights reserved.',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'success' => 'Success!',
        'mode_reader' => 'Reader',
        'mode_creator' => 'Creator',

        // Header
        'reader_title' => 'Digital Library',
        'reader_desc' => 'Explore the latest book collections from the faculty.',
        'creator_title' => 'Creator Studio',
        'creator_desc' => 'Manage the scientific papers and books you uploaded.',

        // Stats
        'stat_time' => 'Reading Time',
        'stat_books' => 'Books Opened',
        'stat_avg' => 'Avg Completion',
        'unit_hours' => 'Hours',
        'unit_books' => 'Books',

        // Buttons & Status
        'upload_new' => 'Upload Book',
        'upload_now' => 'Upload Now',
        'no_cover' => 'No Cover',
        'status_pending' => 'Pending Review',
        'status_rejected' => 'Rejected',
        'btn_read_now' => 'Read Now',
        'btn_view' => 'View',
        'btn_locked' => 'Locked',

        // Empty States
        'empty_upload_title' => 'No uploads yet',
        'empty_upload_desc' => 'Start contributing by uploading your scientific work.',
        'empty_lib_title' => 'Library Empty',
        'empty_lib_desc' => 'No books are available to read at the moment.',

        // Creator Stats
        'stat_total_upload' => 'Total Uploads',
        'stat_pending' => 'Pending Review',
        'stat_approved' => 'Published',
        'stat_rejected' => 'Rejected',

        'admin_title' => 'Administrator Dashboard',
        'admin_desc' => 'Manage users and book approvals.',
        'stat_users' => 'Total Users',
        'review_queue' => 'Book Review Queue',

        'empty_queue' => 'No books are currently awaiting approval.',

        // SECTION READER
        'continue_reading' => 'Continue Reading',
        'continue_reading_desc' => 'Quick access to the books you recently opened.',
        'explore_library' => 'Explore Full Library',
        'btn_continue' => 'Continue',

        // EMPTY STATE READER
        'empty_history_title' => 'No reading history yet',
        'empty_history_desc' => 'Start your reading adventure by exploring our collection.',
        'btn_start_explore' => 'Start Exploring Library',
    ],
    'auth' => [
        'logout' => 'Logout',
    ],

    'upload' => [
        'page_title' => 'Upload Book - FST Library',
        'header_title' => 'Upload Book',
        'cancel' => 'Cancel',
        'form_title' => 'Book Information',
        'label' => [
            'title' => 'Book Title',
            'author' => 'Author',
            'category' => 'Study Program',
            'cover' => 'Book Cover',
            'file' => 'Book File (.epub)',
        ],
        'drag' => [
            'action' => 'Upload image file',
            'or' => 'or drag and drop',
            'hint' => 'PNG, JPG, GIF (Max 2MB)',
            'remove' => 'Remove & Replace Image',
        ],
        'error' => [
            'title' => 'File Size Too Large!',
            'desc' => 'Maximum 2MB.',
            'retry' => 'Try Again',
        ],
        'submit' => 'Save & Upload Book',
    ],
    'categories' => [
        'informatika' => 'Informatics Engineering',
        'sistem_informasi' => 'Information Systems',
        'matematika' => 'Mathematics',
        'biologi' => 'Biology',
        'fisika' => 'Physics',
        'kimia' => 'Chemistry',
        'agribisnis' => 'Agribusiness',
    ],

    'profile' => [
        'page_title' => 'Edit Profile - FST Library',
        'header' => 'Edit Profile',
        'back_dashboard' => 'Back to Dashboard',
        'role_admin' => 'Administrator',
        'role_user' => 'Standard User',
        'label_name' => 'Full Name',
        'label_email' => 'Email Address',
        'email_locked' => 'Cannot be changed',
        'password_section' => 'Change Password',
        'password_hint' => 'Leave blank if you do not want to change the password.',
        'label_new_pass' => 'New Password',
        'label_confirm_pass' => 'Confirm New Password',
        'btn_save' => 'Save Changes',
        'success_update' => 'Profile updated successfully!',
    ],

    'library' => [
        'title' => 'Full Library',
        'back' => 'Back',
        'header_title' => 'All Book Collections',
        'header_desc' => 'Explore the best academic references from the faculty.',
        'search_place' => 'Search title, author, or category...',
        'no_cover' => 'No Cover',
        'read_now' => 'Read Now',
        'empty_title' => 'Not found',
        'empty_desc' => 'Try searching with other keywords or clear filters.',
    ],
];
