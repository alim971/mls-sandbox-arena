import sys
import json
from random import randrange


from selenium import webdriver
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.wait import WebDriverWait

# datetime object containing current date and time
from time import sleep

GOOGLE_CHROME_PATH = '/app/.apt/usr/bin/google-chrome'
CHROMEDRIVER_PATH = '/app/.chromedriver/bin/chromedriver'
x = sys.argv[1]
data = json.loads(x)
server = data['server']
username = data['username']
usernameOp = username.replace(" ", "+")
url = f"https://{server}.op.gg/summoner/userName={usernameOp}"


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
        options.add_argument("--example-flag-" + str(randrange(100)))
        options.add_argument('--disable-dev-shm-usage')
        prefs = {"profile.default_content_setting_values.notifications": 2}
        options.add_experimental_option("prefs", prefs)
        options.binary_location = GOOGLE_CHROME_PATH
        driver = webdriver.Chrome(executable_path=CHROMEDRIVER_PATH, options=options)
        err = False
    except Exception:
        limit -= 1

try:
    if limit <= 0:
        opt = Options()
        opt.headless = True
        opt.add_argument("--example-flag-" + str(randrange(100)))
        prefs = {"profile.default_content_setting_values.notifications": 2}
        opt.add_experimental_option("prefs", prefs)
        driver = webdriver.Chrome(options=opt)

    driver.get(url)

    WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.XPATH, "//*[contains(text(), 'AGREE')]"))
    )
    button = driver.find_element_by_xpath("//*[contains(text(), 'AGREE')]")
    button.click()
    update = driver.find_element_by_id('SummonerRefreshButton')
    update.click()
    try:
        WebDriverWait(driver, 3).until(EC.alert_is_present())
        alert = driver.switch_to.alert
        alert.accept()
    except TimeoutException:
        pass

    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.ID, "right_gametype_soloranked"))
    )
    rankeds = driver.find_element_by_id('right_gametype_soloranked')
    rankeds.click()
    WebDriverWait(driver, 10).until(
        EC.presence_of_element_located((By.CLASS_NAME, "GameItemList"))
    )

    gameDiv = driver.find_element_by_class_name('GameItemList')
    games = gameDiv.find_elements_by_xpath("./*")

    ownScore = 0
    ownPlacement = 0
    ownKda = 0
    ownDmg = 0
    ownDmgPerc = 0

    worstScore = 0
    worstKda = 0
    worstDmg = 0
    worstDmgPerc = 0

    teamDmg = 0
    teamKda = 0
    teamScore = 0

    number = 0
    worstNumber = 0
    worstTimes = 0
    bestTimes = 0
    for el in games:
        game = el.find_element_by_class_name('GameItem')
        WebDriverWait(driver, 10).until(
            EC.presence_of_element_located((By.ID, "right_match"))
        )
        if 'Lose' in game.get_attribute('class').split():
            # game.find_element_by_id('right_match').click()
            btn = game.find_element_by_id('right_match')
            driver.execute_script("arguments[0].click();", btn)
            # sleep(2)
            # detail = game.find_element_by_class_name('GameDetail')
            # content = detail.find_element_by_class_name('MatchDetailContent')
            WebDriverWait(driver, 10).until(
                EC.visibility_of_element_located((By.CLASS_NAME, "Result-LOSE"))
            )
            table = game.find_element_by_class_name('Result-LOSE')
            WebDriverWait(driver, 10).until(
                EC.presence_of_element_located((By.TAG_NAME, "tbody"))
            )
            rows = table.find_element_by_tag_name('tbody').find_elements_by_tag_name('tr')

            ownDmgTmp = 0
            teamDmgTmp = teamDmg

            worstPlacement = 1
            worstDmgTmp = 0
            worstKdaTmp = 0
            worstScoreTmp = 0

            worstUser = ''

            WebDriverWait(driver, 10).until(
                EC.visibility_of_element_located((By.CLASS_NAME, "SummonerName"))
            )
            # WebDriverWait(driver, 10).until(
            #     EC.visibility_of_element_located((By.CLASS_NAME, "Badge"))
            # )

            plac = game.find_elements_by_class_name('Badge')
            summ = 0
            for el in plac:
                tmp = el.text.replace('th', '').replace('nd', '').replace('rd', '')
                if tmp == 'ACE':
                    continue
                elif tmp == 'MVP':
                    summ += 1
                else:
                    summ += int(tmp)

            ace = str(55 - summ)

            for row in rows:
                nameCell = row.find_element_by_class_name('SummonerName')
                name = nameCell.find_element_by_class_name('Link').text
                score = float(row.find_element_by_class_name('Text').text)
                placement = row.find_element_by_class_name('Badge').text.replace('th', '').replace('nd',
                                                                                                   '').replace('rd',
                                                                                                               '')
                if placement == 'ACE':
                    placement = ace
                placement = int(placement)
                if placement >= worstPlacement:
                    worstPlacement = placement
                kda = float(row.find_element_by_class_name('KDARatio').text[:4])
                dmg = int(row.find_element_by_class_name('ChampionDamage').text.replace(',', ''))
                teamDmg += dmg
                teamKda += kda
                teamScore += score
                if name == username:
                    ownScore += score
                    ownPlacement += placement
                    ownKda += kda
                    ownDmg += dmg
                    ownDmgTmp = dmg
                    if placement == int(ace):
                        bestTimes += 1
                elif placement == worstPlacement:
                    worstDmgTmp += dmg
                    worstKdaTmp += kda
                    worstScoreTmp += score
                    worstNumber += 1
                    worstUser = name
            ownDmgPerc += (ownDmgTmp / (teamDmg - teamDmgTmp)) * 100
            worstDmgPerc += (worstDmgTmp / (teamDmg - teamDmgTmp)) * 100
            worstScore += worstScoreTmp
            worstKda += worstKdaTmp
            worstDmg += worstDmgTmp
            if worstUser == username:
                worstTimes += 1
            number += 1
            driver.execute_script("arguments[0].click();", btn)

    print(round(number, 2))

    print(round(ownPlacement / number, 2))
    print(round(ownScore / number, 2))
    print(round(ownKda / number, 2))
    print(round(ownDmg / number, 2))
    print(round(ownDmgPerc / number, 2))

    print(bestTimes)
    print(worstTimes)

    print(round(teamScore / (5 * number), 2))
    print(round(teamKda / number, 2))
    print(round(teamDmg / number, 2))

    print(round(worstScore / worstNumber, 2))
    print(round(worstKda / worstNumber, 2))
    print(round(worstDmg / worstNumber, 2))
    print(round(worstDmgPerc / worstNumber, 2))
# except Exception as e:
#      tb = traceback.format_exc()
#      print >> sys.stderr, tb
finally:
    driver.quit()

