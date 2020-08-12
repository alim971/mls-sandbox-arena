import sys
import json
from random import random

from selenium import webdriver
from selenium.webdriver.support.ui import Select


# datetime object containing current date and time
from time import sleep

from selenium.webdriver.chrome.options import Options

# x = '{"own":false,"0-1":"Amumu","0-1_rune":"AS","0-2":"Amumu","0-2_rune":"AS","0-3":"Amumu","0-3_rune":"AS",' \
#     '"0-4":"Amumu","0-4_rune":"AS","0-5":"Amumu","0-5_rune":"AS","1-1":"Amumu","1-1_rune":"AS","1-2":"Amumu",' \
#     '"1-2_rune":"AS","1-3":"Amumu","1-3_rune":"AS","1-4":"Amumu","1-4_rune":"AS","1-5":"Amumu","1-5_rune":"AS"} '
GOOGLE_CHROME_PATH = '/app/.apt/usr/bin/google-chrome'
CHROMEDRIVER_PATH = '/app/.chromedriver/bin/chromedriver'
x = sys.argv[1]
data = json.loads(x)



# driverLocation = '/usr/local/bin/chromedriver' #if windows
# driver = webdriver.Chrome(executable_path=driverLocation,options=options)
# options.add_argument('--example-flag')

# driver = webdriver.Chrome()
limit = 5
err = True
while err and limit > 0:
    try:
        options = Options()
        options.headless = True
        options.add_argument('--disable-gpu')
        options.add_argument('--no-sandbox')
        options.add_argument("--example-flag")
        options.add_argument('--disable-dev-shm-usage')
        options.binary_location = GOOGLE_CHROME_PATH
        driver = webdriver.Chrome(executable_path=CHROMEDRIVER_PATH, options=options)
        err = False
    except Exception:
        limit -= 1

try:
    if limit <= 0:
        opt = Options()
        opt.headless = True
        opt.add_argument("--example-flag-" + str(random(100)))
        driver = webdriver.Chrome(options=opt)

    driver.get("https://live-draft.herokuapp.com/")

    key = data['key']
    blueKey = driver.find_element_by_id('own-players-input-sandbox-blue')
    redKey = driver.find_element_by_id('own-players-input-sandbox-red')
    blueKey.send_keys(key)
    redKey.send_keys(key)

    driver.find_element_by_xpath('//button[text()="Sandbox"]').click()
    while not len(driver.find_elements_by_id('announcement-label')) > 0:
        sleep(1)
    for x in range(2):
        for y in range(5):
            name = str(x) + '-' + str(y + 1)
            champ = Select(driver.find_element_by_id('pick-' + name))
            champ.select_by_visible_text(data[name])

            rune = Select(driver.find_element_by_id('rune-' + name))
            rune.select_by_value(data[name + '_rune'])

            item = Select(driver.find_element_by_id('item-' + name))
            item.select_by_value(data[name + '_item'])

    buttonBlue = driver.find_element_by_id('confirm-button-0')
    buttonRed = driver.find_element_by_id('confirm-button-1')
    buttonBlue.click()
    buttonRed.click()
    # sleep(2)
    info = driver.find_element_by_id('match-info-text')


    while not 'wins' in info.text:
        sleep(1)
    infoText = info.text
    infoSub = driver.find_element_by_id('match-info-text-sub').text
    print(infoText + " " + infoSub)
# except Exception as e:
#      tb = traceback.format_exc()
#      print >> sys.stderr, tb
finally:
    driver.quit()

