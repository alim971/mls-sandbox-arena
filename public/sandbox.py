import sys
import json

from selenium import webdriver
from selenium.webdriver.support.ui import Select


# datetime object containing current date and time
from time import sleep

from selenium.webdriver.chrome.options import Options

# x = '{"own":false,"0-1":"Amumu","0-1_rune":"AS","0-2":"Amumu","0-2_rune":"AS","0-3":"Amumu","0-3_rune":"AS",' \
#     '"0-4":"Amumu","0-4_rune":"AS","0-5":"Amumu","0-5_rune":"AS","1-1":"Amumu","1-1_rune":"AS","1-2":"Amumu",' \
#     '"1-2_rune":"AS","1-3":"Amumu","1-3_rune":"AS","1-4":"Amumu","1-4_rune":"AS","1-5":"Amumu","1-5_rune":"AS"} '
x = sys.argv[1]
data = json.loads(x)

own = data['own']


options = Options()
options.headless = True
options.add_argument('--disable-gpu')
options.add_argument('--no-sandbox')
options.add_argument("--example-flag")

# driverLocation = '/usr/local/bin/chromedriver' #if windows
# driver = webdriver.Chrome(executable_path=driverLocation,options=options)
driver = webdriver.Chrome(options=options)
options.add_argument('--example-flag')

# driver = webdriver.Chrome()
driver.get("https://live-draft.herokuapp.com/")
print("win")
driver.quit()
# return
# selectOwn = Select(driver.find_element_by_id('player-select-sandbox'))
# key = ""
# if own:
#     key = data['key']
#     selectOwn.select_by_value('own-players')
#     blueKey = driver.find_element_by_id('own-players-input-sandbox-blue')
#     redKey = driver.find_element_by_id('own-players-input-sandbox-red')
#     blueKey.send_keys(key)
#     redKey.send_keys(key)
# else:
#     selectOwn.select_by_value('default-players')
# driver.find_element_by_xpath('//button[text()="Sandbox"]').click()
# while not len(driver.find_elements_by_id('announcement-label')) > 0:
#     sleep(1)
# for x in range(2):
#     for y in range(5):
#         name = str(x) + '-' + str(y + 1)
#         champ = Select(driver.find_element_by_id('pick-' + name))
#         champ.select_by_visible_text(data[name])
#
#         rune = Select(driver.find_element_by_id('rune-' + name))
#         rune.select_by_value(data[name + '_rune'])
#
# buttonBlue = driver.find_element_by_id('confirm-button-0')
# buttonRed = driver.find_element_by_id('confirm-button-1')
# buttonBlue.click()
# buttonRed.click()
# # sleep(2)
# info = driver.find_element_by_id('match-info-text')
#
#
# while not 'wins' in info.text:
#     sleep(1)
# infoText = info.text
# infoSub = driver.find_element_by_id('match-info-text-sub').text
# print(infoText + " " + infoSub)
# driver.close()
#
