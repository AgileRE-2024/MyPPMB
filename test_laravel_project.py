import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import Select

import unittest
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
import time
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

class UserLogoutTest(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_user_login_sukses(self):
        driver = self.driver
        
        username_field = driver.find_element(By.ID, "username")
        username_field.send_keys("1")  

        password_field = driver.find_element(By.ID, "password")
        password_field.send_keys("1")  

        login_button = driver.find_element(By.TAG_NAME, "button")
        login_button.click()

        self.assertIn("/home", driver.current_url)  

        logout_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Logout')]")
        logout_button.click()

        self.assertIn("/", driver.current_url)  

        print("test_user_logout_sukses")


    def tearDown(self):
        self.driver.quit()


class UserLoginTest(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_user_login_sukses(self):
        driver = self.driver
        
        username_field = driver.find_element(By.ID, "username")
        username_field.send_keys("1")  

        password_field = driver.find_element(By.ID, "password")
        password_field.send_keys("1")  

        login_button = driver.find_element(By.TAG_NAME, "button")
        login_button.click()

        self.assertIn("/home", driver.current_url)  
        print("test_user_login_sukses")

    def test_user_login_gagal(self):
        driver = self.driver
        
        username_field = driver.find_element(By.ID, "username")
        username_field.send_keys("invaliduser")  

        password_field = driver.find_element(By.ID, "password")
        password_field.send_keys("wrongpassword")  

        login_button = driver.find_element(By.TAG_NAME, "button")
        login_button.click()

        time.sleep(1) 
        error_message = driver.find_element(By.CLASS_NAME, "error-message")  
        self.assertTrue(error_message.is_displayed())  
        self.assertIn("Invalid username or password.", error_message.text) 
        self.assertIn("/", driver.current_url) 
        print("test_user_login_gagal")       

    def tearDown(self):
        self.driver.quit()

class AdminDeleteScheduleTest(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    
    def test_admin_delete_jadwal(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("1")  
        driver.find_element(By.ID, "password").send_keys("1")  
        driver.find_element(By.TAG_NAME, "button").click()  
        
        delete_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Hapus')]")
        delete_button.click()
        
        alert = driver.switch_to.alert
        alert.accept()
        
        success_message = driver.find_element(By.CLASS_NAME, "success-message")
        self.assertTrue(success_message.is_displayed())

        time.sleep(3)

        print("test_admin_delete_jadwal")

    def tearDown(self):
        self.driver.quit()

class AdminImportScheduleTest(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_admin_tambah_jadwal(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("1")  
        driver.find_element(By.ID, "password").send_keys("1")  
        driver.find_element(By.TAG_NAME, "button").click()  

        driver.find_element(By.ID, "file4").send_keys(r"C:\Users\Sultan Daris\Downloads\output master 2.xlsx")
        driver.find_element(By.ID, "import").click()

        gelombang_element = driver.find_element(By.ID, "gelombang")
        self.assertEqual(gelombang_element.value_of_css_property("color"), "rgba(0, 0, 0, 1)") 

        print("test_admin_import_jadwal")

    def tearDown(self):
        self.driver.quit()

class AdminRecapScore(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_admin_tambah_jadwal(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("1")  
        driver.find_element(By.ID, "password").send_keys("1")  
        driver.find_element(By.TAG_NAME, "button").click()  
        
        rekap_nilai_link = driver.find_element(By.LINK_TEXT, "Rekap Nilai")
        rekap_nilai_link.click()

        detail_buttons = driver.find_elements(By.CLASS_NAME, "toggle-button")
        detail_buttons[0].click()

        gelombang_content = driver.find_element(By.CLASS_NAME, "gelombang-content")
        self.assertTrue(gelombang_content.is_displayed())

        time.sleep(1)
        print("test_admin_rekap_nilai")

    def tearDown(self):
        self.driver.quit()

class AdminAddScheduleTest(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_admin_tambah_jadwal(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("1")  
        driver.find_element(By.ID, "password").send_keys("1")  
        driver.find_element(By.TAG_NAME, "button").click()  

        tambah_jadwal_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Tambah Jadwal')]")
        tambah_jadwal_button.click()

        driver.find_element(By.ID, "gelombangName").send_keys("Gelombang masako")
        driver.find_element(By.ID, "date").send_keys("01-01-2021")
        
        gelombang_select = Select(driver.find_element(By.ID, "gelombang"))
        gelombang_select.select_by_value("1")  # Select "Gelombang 1"
        
        semester_select = Select(driver.find_element(By.ID, "semester"))
        semester_select.select_by_value("ganjil")  # Select "Ganjil"

        driver.find_element(By.ID, "time").send_keys("10:00 AM")

        submit_button = driver.find_element(By.ID, "tambah")

        submit_button.click()

        success_message = driver.find_element(By.CLASS_NAME, "success-message")
        self.assertTrue(success_message.is_displayed())


        time.sleep(3) 

        print("test_admin_tambah_jadwal")

    def tearDown(self):
        self.driver.quit()

class HostLink(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_admin_tambah_jadwal(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("1234")  
        driver.find_element(By.ID, "password").send_keys("astria")  
        driver.find_element(By.TAG_NAME, "button").click()  

        tambah_jadwal_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Masuk Ruang')]")
        tambah_jadwal_button.click()
        
        current_url = driver.current_url
        self.assertIn("/", current_url)
        
        time.sleep(3)
        print("test_admin_tambah_jadwal")

    def tearDown(self):
        self.driver.quit()

class PimpinanScore(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_pimpinan_detail(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("2")  
        driver.find_element(By.ID, "password").send_keys("2")  
        driver.find_element(By.TAG_NAME, "button").click()  

        time.sleep(4)


        detail_buttons = driver.find_elements(By.ID, "detail")
        detail_buttons[0].click()

        gelombang_content = driver.find_element(By.CLASS_NAME, "gelombang-content")
        self.assertTrue(gelombang_content.is_displayed())
        
        time.sleep(3)
        print("test_pimpinan_detail")

    def tearDown(self):
        self.driver.quit()

class PimpinanScoreDownload(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_pimpinan_download(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("2")  
        driver.find_element(By.ID, "password").send_keys("2")  
        driver.find_element(By.TAG_NAME, "button").click()  

        time.sleep(4)

        detail_buttons = driver.find_elements(By.ID, "download")
        detail_buttons[0].click()

        time.sleep(3)
        print("test_pimpinan_download")

    def tearDown(self):
        self.driver.quit()

class PewawancaraScore(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_pewawancara_score(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("187221001")  
        driver.find_element(By.ID, "password").send_keys("5lKbWMKUSl")  
        driver.find_element(By.TAG_NAME, "button").click()  

        time.sleep(4)

        detail_buttons = driver.find_elements(By.ID, "detail")

        if detail_buttons:
            detail_buttons[0].click()
        else:
            self.fail("No 'Details' button found on the page.")
        
        time.sleep(2) 
        
        motivation_input = driver.find_element(By.ID, "q1")
        motivation_input.clear()
        motivation_input.send_keys("85")
        
        time.sleep(2) 

        quality_input = driver.find_element(By.ID, "q2")
        quality_input.clear()
        quality_input.send_keys("90")

        ability_input = driver.find_element(By.ID, "q3")
        ability_input.clear()
        ability_input.send_keys("88")

        matriculation_input = driver.find_element(By.ID, "q4")
        matriculation_input.clear()
        matriculation_input.send_keys("Yes")

        notes_input = driver.find_element(By.ID, "q5")
        notes_input.clear()
        notes_input.send_keys("Good performance, needs improvement in technical aspects.")
        
        submit_button = driver.find_element(By.ID, "simpan")
        submit_button.click()
    
        
    def tearDown(self):
        self.driver.quit()

        print("test_pewawancara_score")

class PewawancaraLink(unittest.TestCase):

    def setUp(self):
        self.driver = webdriver.Chrome()
        self.base_url = "http://127.0.0.1:8000"  
        self.driver.get(self.base_url)

    def test_pewawancara_link(self):
        driver = self.driver
        
        driver.find_element(By.ID, "username").send_keys("187221001")  
        driver.find_element(By.ID, "password").send_keys("5lKbWMKUSl")  
        driver.find_element(By.TAG_NAME, "button").click()  

        time.sleep(4)
        tambah_jadwal_button = driver.find_element(By.XPATH, "//button[contains(text(), 'Masuk Ruang Zoom')]")
        tambah_jadwal_button.click()
        
        current_url = driver.current_url
        self.assertIn("/", current_url)
        
        time.sleep(3)

        print("test_pewawancara_download")

    def tearDown(self):
        self.driver.quit()

if __name__ == "__main__":
    unittest.main()
