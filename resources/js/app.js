import './bootstrap';

import { createClient } from '@supabase/supabase-js'

// Initialize the Supabase Client
const supabaseUrl = 'https://pevrthazwqqzmxrthphg.supabase.co'
const supabaseAnonKey = '16bf8f6dbe12140f1ac739bba39e7bdc49a96953ba8c19f12b7de01f440fafa9' // Your PUBLIC anon key

window.supabase = createClient(supabaseUrl, supabaseAnonKey)