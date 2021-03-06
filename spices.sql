DROP SCHEMA IF EXISTS spices CASCADE;
CREATE SCHEMA spices;

SET search_path = spices;

CREATE TABLE Spices(
  name varchar(50),
  descr text,
  price decimal(13,2),
  size varchar(10),
  id serial NOT NULL PRIMARY KEY,
  food varchar(255),
  category varchar(100));
  
CREATE TABLE Users(
  email varchar(50),
  username varchar(50),
  password_hash CHAR(40) NOT NULL,
  user_Id serial PRIMARY KEY);
  
 CREATE TABLE Address(
	fname varchar(50) NOT NULL,
	lname varchar(50) NOT NULL,
	street varchar(255) NOT NULL,
	street2 varchar(50),
	zip int NOT NULL,
	city varchar(255) NOT NULL,
	state_code varchar(2) NOT NULL,
	user_id int NOT NULL,
	index_id serial PRIMARY KEY,
	FOREIGN KEY (user_id) REFERENCES Users);
  
CREATE TABLE Category(
  category varchar(50) PRIMARY KEY );
  
CREATE TABLE Spice_Category(
  id int NOT NULL REFERENCES Spices,
  category varchar(50) NOT NULL REFERENCES Category,
  PRIMARY KEY (id, category));
  
 CREATE TABLE Cards(
	cardOwner varchar(50),
	user_id int,
	securityNo smallint,
	cardType varchar(50),
	cardNumber varchar(35) PRIMARY KEY,
	expMonth smallint,
	expYear smallint,
	FOREIGN KEY (user_id) REFERENCES Users);
	
	
CREATE TABLE Orders(
	order_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	user_id int,
	order_id serial PRIMARY KEY,
	FOREIGN KEY (user_id) REFERENCES Users);
	
CREATE TABLE Shipping(
	fname varchar(50) NOT NULL,
	lname varchar(50) NOT NULL,
	street varchar(255) NOT NULL,
	street2 varchar(50),
	city varchar(50),
	state_code varchar(2),
	zip int,
	shipping_id int PRIMARY KEY REFERENCES Orders(order_id),
	tracking_no varchar(50),
	carrier varchar(50));
	
CREATE TABLE Order_Details(
	product_id int,
	quantity int,
	price decimal(13,2),
	order_id int REFERENCES Orders,
	FOREIGN KEY (product_id) REFERENCES Spices,
	PRIMARY KEY (product_id, order_id));

-- 1-20
INSERT INTO Spices VALUES('Turmeric','Turmeric, essential to curry powder, is a member of the ginger family. It has a light, musky flavor along with a brilliant golden-orange color for which it is famous throughout the world. It contains the compound curcumin, which is a strong anti-inflammatory. In Asia, its main use for thousands of years was as a dyestuff. At one time, sun worshippers, whose sacred color was yellow, dyed their textiles with the very expensive saffron. When it was discovered that the very inexpensive turmeric produced the same brilliant color, the sacred saffron was guarded for special culinary dishes.',6.29,8,1,'Lamb, fish, beef, potatoes, artichokes, rice dishes, curry','Indian,Thai');
INSERT INTO Spices VALUES('Amchoor Powder','Amchoor is a powder made from dried unripe green mangoes. It has a delicious honey-like fragrance and a sour fruity flavor. Amchoor is used in curries, chutneys, pickles, and stir-fries, both with vegetables and with meats. It has a slight tenderizing effect in meat dishes. Use this powder to add a fruit flavor without adding moisture, or as a souring agent.',7.99,8,2,'Okra curry, legume dishes, chutney','Indian');
INSERT INTO Spices VALUES('Cardamon, Green ','Cardamom has a unique flavor and aroma that is hard to put into words. It defies the boundaries of normal sensory comparisons. It is compellingly strong, yet delicate; sweet, yet powerful; with an almost eucalyptus freshness.  Cardamom is used in different ways by different cultures: in the Middle East to flavor coffee, in Scandinavian communities as a dessert baking spice. In India it is a savory spice for curries. Elsewhere it is used for poached fish, meat loaf, fish stews and sweet potatoes.',3.99,1,3,'Coffee, curry, fish, meat loaf, sweet potatoes','Indian, Middle Eastern, Scandinavian');
INSERT INTO Spices VALUES('Cayenne Pepper',': Cayenne pepper is our hottest ground red pepper, this cayenne clocks in at 40,000 scoville heat units. This pepper will zip up any dish. When a recipe calls for red pepper, this is the pepper it means.',9.29,8,4,'Indian, Cajun');
INSERT INTO Spices VALUES('Cilantro','Cilantro is the leaf of the coriander plant. Its flavor is quite distinctive, and people usually love it or hate it--nothing in-between! Most recipes call for fresh cilantro, but this can be hard to come by in colder climates. In a pinch, substitute our dried leaves. For those just acquiring a taste for cilantro, the dried leaves are a good place to start. Their flavor is a bit more subtle than the fresh herb.',7.99,4,5,'Avocado, chicken, fish, ice cream, lamb, lentils, mayonnaise, peppers, pork, rice, salads, salsas, shellfish, tomatoes, yogurt','Greek and Turkish, Indian, Mexican, Middle Eastern, Spanish');
INSERT INTO Spices VALUES('Coriander Seeds, Whole ','Coriander is a pleasantly sweet spice with a lemony top note. It is commonly used in chili and curry dishes. The coriander plant produces both a spice and an herb. The leaf is known as cilantro and when the plant goes to seed, we harvest the coriander seed. Coriander is used in many types of ethnic cooking, such as Latino, Middle Eastern, and Indian. In this country, it is also used to flavor cookies, pastries, breads, sausages and corned beef.',3.99,8,6,'curry, fish, ham, lamb, lentils, pork, stuffing, tomatoes, turkey','Eastern European, English, Greek and Turkish, Indian, Mexican, Middle Eastern');
INSERT INTO Spices VALUES('Cumin Seed','Cumin is a crucial ingredient in several world cuisines. It has a unique and potent flavor crucial to Indian curries, where it is often roasted before grinding to impart a toasted, nutty flavor. The aromatic, somewhat bitter, taste is essential to good chili. Virtually all Mexican meat or bean dishes contain a generous amount of cumin (called "comino" in Mexican recipes) as do foods from many other Latin American countries. Swiss and Dutch countries use cumin seed to flavor certain cheeses, while various European countries flavor breads with cumin.',6.29,8,7,'beans, chicken, couscous, curry, eggplant, fish, lamb, lentils, peas, pork, potatoes, rice, sausages, soups, stews, eggs','Greek and Turkish, Indian, Mexican, Middle Eastern');
INSERT INTO Spices VALUES('Curry Powder, Hot','Hot Curry Powder gives you the same full flavor as our sweet curry plus the added element of heat, derived from extra cayenne red pepper and spicy ginger. While this curry is hot by most Western standards, it is not as fiery as some Indian food, so do not be afraid of burning yourself with it.',6.99,4,8,'Fish, lamb, shrimp, beef, chicken, curry, potatoes','Indian');
INSERT INTO Spices VALUES('Sweet Curry Poweder','For those of you who are purists or want to put your own personal mark on your curry dishes, we offer you the freshest individual ingredients to blend your own curry powder. In India, it’s said that “there are as many curry powders as cooks,” since each cook mixes her own curry powder according to her family’s spice preferences, passed down from generation to generation. For those of us without this tradition, our sweet yellow curry powder is a great place to start. It has a rich, balanced flavor that iss perfect in any recipe calling for curry powder.',6.99,4,9,'Fish, lamb, shrimp, beef, chicken, curry, potatoes','Indian');
INSERT INTO Spices VALUES('Fenugreek Leaves, Dried','Also known as kasuri methi, fenugreek leaves are used throughout India, North Africa and the Middle East. Fenugreek leaves are used in many curry masalas, and are also delicious in potato dishes, flatbreads and soups.  These dried leaves have a warm, savory aroma and a slightly nutty, pea-like taste. Try crumbling them over vegetable dishes or grinding them into the base for sauces to impart a wonderful flavor',6.99,4,10,'chicken, curries, legumes, potatoes, rabbit, vegetable dishes','Indian');
INSERT INTO Spices VALUES('Fenugreek Seeds, Whole','Fenugreek seeds are used mainly in Middle Eastern cooking. It is an ingredient in most curries and chutneys.  Like fennel, fenugreek has been cultivated for centuries primarily because it was thought to have many healing virtues. It was even an ingredient in the "holy smoke" which was a part of the Egyptian embalming ritual. An old-fashioned Arabic greeting was, "May you tread in peace the soil where fenugreek grows." Indians often roast the seed before grinding, giving it a somewhat sweeter flavor.',3.99,8,11,'chicken, curries, legumes, potatoes, rabbit','Greek and Turkish, Indian, Middle Eastern');
INSERT INTO Spices VALUES('Spanish Saffron, Superior Grade ','Saffron is the dried yellow stigmas from a small purple crocus. Each flower provides only three stigmas, which must be carefully hand-picked and then dried, an extremely labor-intensive process. It takes 225,000 stigmas to make one pound of saffron, making saffron the most expensive spice in the world. Fortunately, a little saffron goes a long way as a colorant and flavoring for cheeses, pastry, rice and seafood. Saffron is used in spice blends for paella, curry, kheer and bouillabaisse. Powdered saffron loses its flavor more readily and can be easily adulterated with imitations. Saffron is native to the Mediterranean, and most imported saffron comes from Spain.',9.49,0.035274,12,'chicken, curries, fish, lamb, mussels, paella, rice, risotto, shellfish, soup, tomatoes','Indian,English');
INSERT INTO Spices VALUES('Adobe Seasoning, Salt-Free ','Adobo Seasoning is an authentic Mexican spice mixture traditionally used for South of the Border flavor.  Flavorful, but not too hot, this blend will lend a Latin flavor to nearly any dish. Add 1/2 teaspoon per pound for chicken, beef, pork chops, bean dip, or to spice up a bland salsa. Makes a great base for taco or fajita seasonings. If you make your own guacamole, this adobo will elevate it to a new level! Available in city style (with salt), or rural (no-salt) style. Hand mixed from: onion powder, garlic powder, Tellicherry black pepper, ground cumin, powdered Mexican oregano (city style blend contains salt and sugar).',9.99,8,13,'chicken, beef, pork chops, bean dip, salsa, guacamole, tacos, fajitas','Mexican');
INSERT INTO Spices VALUES('Aleppo Pepper','Aleppo chili pepper comes to us from southern Turkey, near the Syrian town of Aleppo, which is considered one of the culinary meccas of the Mediterranean. It has a moderate heat level with some fruitiness and mild, cumin-like undertones, with a hint of a vinegar, salty taste. Use it for authentic chili flavor in any Middle Eastern or Mediterranean dish.',9.99,8,14,'chili, grilled chicken breast, steak, pork, potatoes, deviled eggs, tuna salads, fish','Mexican, Middle Eastern, Greek and Turkish');
INSERT INTO Spices VALUES('Annatto Seed','Annato seed is also known as achiote. This seed grows on the annato tree. It is used primarily in Mexican and Caribbean cooking to impart a rich yellow/orange color. Annato seed makes a good substitute for the golden coloring in saffron, at a fraction of the cost. It does NOT, however, duplicate the unique flavor of saffron!',3.99,8,15,'Moro de habichuelas, tacos al pastor, soups','Mexican,Caribbean');
INSERT INTO Spices VALUES('Guajillo Chile Peppers','Along with anchos, they are the most commonly used chiles in Mexico. What the anchos are to "deep" and "rich", guajillos are to "spicy" and "dynamic"... a puree of toasted, rehydrated guajillo sings with a chorus of bright flavors that combine spiciness, tanginess (like cranberry), a slight smokiness and the warm flavor of a ripe, juicy, sweet tomato; the flavors go on and on.',4.69,4,16,'Mole, sauces, soup, tacos al pastor, salsa','Mexican');
INSERT INTO Spices VALUES('Ancho Chile Peppers','Ancho peppers are the dried version of Poblano, or "people" peppers. Their flavor is somewhat sweet and somewhat raisin-like, with medium heat. The outer skin has a rich, sweet, raisin-like flavor, which is most commonly associated with the flavor of the dish chili; the inner veins and of the pepper are hot. When you buy the whole pod, you have the advantage of being able to separate these two distinct flavors. You can grind the whole dried pod in a blender (with or without the hot seeds, depending on heat preferences). You can also "bring them back to life" by pouring boiling-hot water over them and steeping for about 20 minutes.',4.49,4,17,'Mexican dishes, chili, meat rubs, sauces, mole','Mexican');
INSERT INTO Spices VALUES('Pasilla Negro Chile Peppers','Pasilla chiles have a long, purple pod similar to ancho chile peppers.  Pasillas are one of the most popular chiles. Pasilla teams with ancho and mulato chiles (a version of ancho) to form the "holy trinity" used in making moles. They are great for sauces of all sorts. They clock in at 3-5 heat level, on a scale of 10.',9.19,4,18,'Mole, Mexican dishes, sauces','Mexican');
INSERT INTO Spices VALUES('Chili Powder','Chile pepper is often confused with chili powder. When a recipe refers to chile pepper, this means pure chile pepper. The most commonly used is the ancho pepper in its ground form. A chili powder, on the other hand, is a mixture of ingredients. All of our chili powders are salt free, mixed 1500 times by hand and triple sifted to achieve exactly the right flavor and color combination; use 1-3 Tblsp. per quart of chili, to suit your preference. Ingredients: sweet ancho chile pepper, cumin, garlic, and powdered Mexican oregano.',4.69,4,19,'Chili, Mexican dishes, curry, potatoes, spice rubs','Mexican');
INSERT INTO Spices VALUES('Cinnamon,Ceylon ','These tightly-rolled quills are very delicate. They feel like parchment paper, which you can break apart with your fingertips. This is the preferred cinnamon in Europe and Mexico. It''s often called for in pickling, spiced pears or peaches, and in the brewing of hot cocoa.  You will find its flavor to be quite distinct from cassia cinnamon. Ceylon cinnamon has a much lower volatile oil content, between 1 and 2%, but its flavor has a subtle complexity that you won''t experience with the stronger, spicier cassia. You might even notice the delicate flavor of citrus interwoven in the scent of this cinnamon',9.19,4,20,'custard, cinnamon ice cream, Dutch pears, stewed rhubarb, steamed puddings, dessert syrups, whipped cream','Mexican, English, Middle Eastern, Scandinavian');
-- 21-40
INSERT INTO Spices VALUES('Epazote','Epazote is common to Mexican cooking. While fresh epazote should be your first choice, it is often difficult to find. When substituting our dried herb, use one-half the amount specified for fresh leaves. Epazote is most commonly found in bean dishes. It is also used in soups and moles.  Epazote has a slightly tangy flavor, reminiscent of oregano. It is used both for flavor and for its ability to reduce the flatulence associated with bean dishes.',12.99,4,21,'Bean dishes, soups, mole','Mexican');
INSERT INTO Spices VALUES('Oregano, Mexican','This type of oregano, grown in Mexico or California, has a very different flavor than the Mediterranean oregano - stronger and more bitter. More robust than Greek, this oregano stands up to the stronger flavors used in Mexican cooking such as hot chili peppers and cumin, which could overwhelm the more delicate oregano from the Mediterranean.',6.99,4,22,'artichokes, beans, chicken, eggplant, fish, lamb, mushrooms, pasta, peppers, pizza, pork, potatoes, rabbit, sausages, tomatoes, veal, zucchini','Mexican');
INSERT INTO Spices VALUES('Vanilla Beans, Mexican','Mexico has always had the reputation for the best vanilla, but it is much more difficult and expensive to produce the highest quality vanilla crops. Vanilla is native to the Latin American isthmus, where it has been cultivated and used as both flavoring and currency for centuries. Although vanilla beans are grown in several locations today, until the 1800’s Mexico maintained a monopoly on vanilla beans in spite of the fact that explorers constantly uprooted the orchid vines to replant in their native lands. Botanists finally came to realize that the melipone bees, native only to Mexico, were pollinating the flowers. Eventually, a man on the island of Reunion discovered that the pointed stick of a bamboo shoot could be used to hand-pollinate the flowers. Once this was discovered, the French planted vanilla on many of the tropical islands they ruled. To this day, former French colonies within about 25 degrees of the equator (which enjoy warm, tropical climates) produce about 80% of the world’s vanilla.',4.49,3,23,'apples, apricots, chocolate, custards, fish, fruit, ice cream, plums, shellfish','Mexican');
INSERT INTO Spices VALUES('Anise Seed, Whole Spanish ','Anise seed is native to the Mediterranean basin, and has been used throughout history in both sweet and savory applications. Anise has long been known as an aid to digestion. The Romans ended their elaborate feasts with anise cakes. In the Mediterranean, anise is featured heavily in cakes, breads, cookies and liquors. In small amounts, anise makes a nice addition to sausage, or in tomato sauce.',7.99,8,24,'sausage, chutney, brisket, bread, cake','German, Italian, Spanish');
INSERT INTO Spices VALUES('Basil, California Sweet','Basil has now become the most popular herb used in this country. Basil, garlic and tomatoes form an unbeatable trio.  Until recently, French basil had a reputation for supremacy. Now, domestic basil is generally regarded as superior to imported basil, in part because the drying process in California has advanced to a very high level. The fresh, sweet basil flavor and nice green color is maintained beautifully. Stored properly, the flavor of these large leaf flakes can stay strong and fresh for months.',7.99,4,25,'cheese, chicken, duck, eggplant, eggs, fish, lamb, liver, olive oil, onions, pasta, pesto, pizza, pork, potatoes, rabbit, salads, shellfish, soups, sweet peppers, tomatoes, veal, vegetables, vinegars, zucchini, tomato sauce','Italian');
INSERT INTO Spices VALUES('Fennel Seeds, Whole ','Fennel Seed has a delicate flavor; light and sweet, similar to anise. Use of fennel has a long history, dating back to the Chinese and Hindus who used it as a cure for snake bites. Fennel was hung over doors in the Middle Ages to ward off evil spirits.',5.29,8,26,'Cheese, sausage, fish, sauces','Greek and Turkish, Indian, Italian');
INSERT INTO Spices VALUES('Garlic Powder, Granulated','Regular granulated garlic is the standard for use in most recipes. It takes about 20 minutes for full flavor release, but is fine enough to taste garlicky in a much shorter time. These garlic products are pure dehydrated garlic: no preservatives, no anti-caking agents.',5.29,8,27,'beans, beef, beets, cabbage, chicken, eggplant, fish, lamb, lentils, mushrooms, pasta, pork, potatoes, rice, shellfish, spinach, tomatoes, zucchini','Cajun, Caribbean, Eastern European, Greek and Turkish, Italian');
INSERT INTO Spices VALUES('Italian Herb Blend','One whiff of this blend will bring to mind everything you recall about dining in your favorite Italian restaurant -- and the scent gets much better when you cook with it!  Use 1 teaspoon per cup of tomato sauce to make flavorful sauce for spaghetti, pizza, veal parmesan, or pasta noodles. To improve the taste of a store-bought pizza, crush herbs between your palms and sprinkle over the top before baking. Use it to roast Italian-style chicken or fish.  Hand mixed from: oregano, basil, marjoram, thyme, and crushed rosemary.',6.99,4,28,'sauces, pizza, chicken, fish','Italian');
INSERT INTO Spices VALUES('Tomato Powder','Tomato powder has a flavor so rich and tomato-ey you will not believe it, until you taste it. It is the sweetest red tomatoes of the crop, spray-dried into a fine powder.',8.99,7,29,'sauces, pasta, bread, stews, gumbo, chili','Italian');
INSERT INTO Spices VALUES('Bay Leaves, Turkish ','The flavor of these Turkish bay leaves is far milder and more complex than that of domestic bay; it adds a subtly sweet astringency to dishes. Only one or two are needed to enhance a whole roast, pot of soup or stew.',7.99,4,30,'beans, game, lentils, potatoes, risotto, shellfish, soups, stews, tomatoes','Cajun, Eastern European, English, Greek and Turkish, Hungarian, Irish');
INSERT INTO Spices VALUES('Sassafras Leaves, Organic Powdered ','Gumbo file powder is a necessity for cooking authentic Creole or Cajun cuisine. Quite simply, gumbo file powder is the powdered leaves of the sassafras tree. When ground, they have a rich, cooling smell, reminiscent of eucalyptus crossed with juicy fruit gum.',7.99,4,31,'gumbo, soups, stews','Cajun');
INSERT INTO Spices VALUES('Cajun Seasoning','Cajun Seasonings are useful, whether you are a Cajun cook or not. This is the flavor you get when you taste a blackened dish; just be aware that the actual blackening comes from a very hot fire. This can be from a very hot gas grill, or in a professional kitchen - if you try to blacken in a home kitchen you are likely to set off the fire alarm. We really like this seasoning without being blackened as it iss just a darned tasty, all-purpose seasoning.',4.69,4,32,'fish, chicken, steak, pork, ribs, eggs, potatoes','Cajun');
INSERT INTO Spices VALUES('Parsley Flakes','Parsley flakes make a colorful garnish.  The rich forest green color of this herb, along with its sweet flavor, makes it the ideal herb for both flavor and garnish.  Parsley is very lightweight--one ounce will give you almost two cups of parsley.',6.99,4,33,'chicken, eggplant, eggs, fish, game, lentils, mushrooms, mussels, pasta, peas, potatoes, poultry, rice, seafood, tomatoes, zucchini, lemon','Cajun, Eastern European, Greek and Turkish');
INSERT INTO Spices VALUES('Scallions','Scallions, from a non-bulb-forming onion, are similar in their delicate, mild flavor to young green onions. Add them to soups, sauces, salads, eggs, or vegetable medleys, or as an attractive garnish on nearly any savory dish.  These fancy freeze-dried scallions retain nearly all the flavor and color of fresh scallions, with a much longer shelf life. Keep them around to throw together beautiful dishes quickly.  Freeze-dried scallions are extremely lightweight - 1/4 ounce is about 1 cup of scallions.',4.59,1,34,'soups, sauces, salads, eggs','Cajun');
INSERT INTO Spices VALUES('Allspice Berries, Whole','Our premium berries from Jamaica have a sweet flavor reminiscent of cloves, cinnamon and a hint of nutmeg. Even though its name suggests a mixture of spices, allspice is a single berry from the Jamaican bayberry tree. Its complex sweetness lends allspice a great deal of versatility. Whole, it is used in poached fish stock, vegetable and fruit pickles, and for wild game. Ground, it is found in spice cakes, puddings, cookies, gravies, bbq sauce and is a key ingredient in Caribbean jerk dishes. It is often used in German sausages and is so common in English baking that it is sometimes known as English Spice.',5.59,4,35,'beef, beets, cabbage, carrots, corned beef, fruit pies, game, grains, lamb, meats, onions, pumpkin, rabbit, soups, spinach, squash, stews, sweet potatoes, tomatoes, turnips','Caribbean, Eastern European');
INSERT INTO Spices VALUES('Arrowroot Powder','Arrowroot is a wonderful, clear thickener used in gravies, sauces and pie fillings. It is also more easily digested than other thickening agents. While true arrowroot comes from the marantha plant of St. Vincent, this is currently unavailable. Our arrowroot comes from the more common cassava, from Brazil. It contains high amounts of amyl pectin, a starchy thickener',6.29,8,36,'gravy, stews, sauces','Caribbean, Irish');
INSERT INTO Spices VALUES('Ginger, Powdered','Dehydrated Ginger root comes in whole and powdered form. It is very healthy and useful for baking, marinades and sauces. Once you find ginger creeping into your cooking, you will be surprised at the subtle way it has of incorporating itself into more and more of your culinary repertoire.',5.59,4,37,'carrots, chicken, chocolate, fruit, ham, ice cream, melon, onions, pork, pumpkin, rice, tomatoes.','Caribbean, Chinese and Far Eastern, German, Scandinavian, Thai');
INSERT INTO Spices VALUES('Mace, Ground ','Mace is the outer shell of the nutmeg fruit. It has a lighter, sweeter flavor.',4.29,1,38,'meatballs, doughnuts, stews, sauces, stuffing','Caribbean, Eastern European, German');
INSERT INTO Spices VALUES('Nutmeg, Ground ','Nutmeg has a flavor that is quite strong. In small amounts, it blends in with great subtlety. You will find it called for in many vegetable recipes such as squash, spinach, and sweet potato pie, as well as in meatballs and sausages. French white sauces often call for a pinch.',12.99,4,39,'broccoli, cabbage, carrots, cauliflower, cheese, custards, eggs, fruits, lamb, pasta, potatoes, pumpkin, raisins, ricotta cheese, rice, sausages, spinach, squash, stuffing, veal','Caribbean, Eastern European, English');
INSERT INTO Spices VALUES('Hibiscus Blossoms','Also known as flor de Jamaica, roselle or carcade, hibiscus has a tart, pomegranate-like flavor, and is usually steeped in hot water like tea. Hibiscus is native to West Africa, where it is used to make bissap, the national drink of Senegal. It is the main ingredient in the popular Mexican drink “Agua de Jamaica.” It is wonderful in savory sauces and marinades. Hibiscus also makes a great base for a sweetened reduction sauce, and is used in jams and preserves. Hibiscus syrup or frosting is naturally pink and delicious on baked goods. Brewers love hibiscus for its sweet-tart flavor and bright color.',6.99,4,40,'sauces, marinades, jams, syrup, Aqua de Jamaica','Caribbean, Mexican');
-- 41-60
INSERT INTO Spices VALUES('Tien Tsin Chile Peppers','Tien Tsin chile peppers are named after the province of China in which they are harvested.  These chile peppers fall under the category of exotics, or chile peppers once more commonly grown in Asia but now popularly grown here also. They adapt themselves beautifully to the Hunan and Szechwan styles of cooking. This exceptional crop is one of the finest we have ever seen. Dont let the lovely appearance of these bright red shiny peppers fool you -- they are 8-9 on the heat scale!  If you are trying to decide on the amount you need, they are very light and come dozens per ounce.',4.49,4,41,'Chinese dishes, chili, pho, rice, curry, rice', 'Chinese and Far Eastern, Eastern, Indian, Thai');
INSERT INTO Spices VALUES('Chinese Five Spice Powder','The Chinese believe that it is important to incorporate the principal of the yin and the yang into their meals, thus the heat of a dish should be counter-balanced by an equally cooling ingredient. When you try this seasoning you will be surprised at how beautifully the flavors -- sweet, warm, cool and spicy -- blend. This is an extremely versatile mixture suited to rice, vegetables, pork and virtually any type of stir fry. A pinch can add new excitement to muffins, nut breads, or even pancake or waffle batter. Great mixed with coffee grounds for brewing coffee!  Gently hand mixed from China Tung Hing cassia cinnamon, powdered star anise and anise seed, ginger and ground cloves.',6.99,4,42,'Chicken, pork, beef, Chinese dishes, rice, vegetables, breads', 'Chinese and Far Eastern');
INSERT INTO Spices VALUES('Cinnamon, Chinese "Tung Hung" Cassia ','This cinnamon, Cinnamomum cassia, has a high 3 - 4% natural oil and is appreciated for its rich, sweet yet slightly spicy flavor. China cassia cinnamon is often preferred by bakers for its milder sweet flavor, which blends better in dishes where cinnamon is not meant to be the dominant flavor. It is a wonderful all-around baking cinnamon.',4.69,4,43,'spice cakes, pies, sticky buns, linzertortes, pumpkin bread, cheesecake, apple strudel, baklava, French toast, oatmeal, hot cocoa','Chinese and Far Eastern');
INSERT INTO Spices VALUES('Cloves, Whole','Cloves are by far the most prominent of the spices known as "flower spices."  Just before the buds blossom, they turn pink, at which point they must be harvested immediately. One tree yields about a seven-pound harvest. The flavor of the clove is rich, sweet and sultry. The high percentage of eugenol will produce a numbing effect if you put a whole clove in your mouth. In fact, before modern anesthetics, dentists often prescribed that their patients with toothaches pack cloves around the infected area to numb the pain.',9.19,4,44,'apples, beets, game, ham, lamb, pumpkin, sausage, tea, tomatoes, walnuts, wine','Chinese and Far Eastern');
INSERT INTO Spices VALUES('MSG','MSG has a wonderful ability to bring out the flavor in anything it is added to. The Japanese term "Umami" describes this earthy flavor enhancer.  Monosodium glutamate is a sodium salt of glutamic acid. It can be made from yeast or sugar beet molasses, or by fermenting special bacteria. Contrary to popular belief, MSG is a harmless ingredient for most people.',6.99,16,45,'beef, fish, chicken, duck, rabbit, pork, sauces, cheese', 'Chinese and Far Eastern');
INSERT INTO Spices VALUES('Mustard Powder, Hot Yellow','This is the sharp, hot type of mustard that usually comes with egg rolls in Chinese restaurants. It will make your eyes water!',3.99,8,46,'Chicken, chili, spice rubs, mustard, beef', 'Chinese and Far Eastern, German');
INSERT INTO Spices VALUES('Sansho Japanese Pepper, Whole','The unripened seedpods of the Japanese prickly ash (Zanthoxylum piperitum), these little green fireballs really pack a punch! Hand-harvested in Japan’s Kochi Prefecture and quickly air-freighted to The Spice House, they have a sharp, citrusy taste, with an electrifying tingling numbness that can linger for more than ten minutes. Related to Sichuan peppercorns, but far stronger and more numbing, sansho is used in Asian cuisines to add dimension to broths and sauces for fish, pork and vegetable dishes. It’s a common seasoning for chicken yakitori and broiled eel. Food science writer Harold McGee wrote: "they produce a strange, tingling, buzzing, numbing sensation that is something like … a mild electrical current. Sanshools appear to act on several different kinds of nerve endings at once, induce sensitivity to touch and cold in nerves that are ordinarily nonsensitive, [causing] a kind of general neurological confusion."',21.00,1,47,'sauces, vegetables, chicken, eel', 'Chinese and Far Eastern');
INSERT INTO Spices VALUES('Sichuan Peppercorns','Sichuan pepper (xanthoxylum peperitum) is native to the Sichuan province of China and is not related to black pepper (peper nigrum), which is native to India. This pepper is quite aromatic but not very hot. Before Asian cultures were introduced to chile pepper, Sichuan pepper was used along with ginger to give heat to many dishes. The heat in modern Sichuan cooking comes instead from red chile pepper (capsicum annum), introduced to Asia in the 15th century. Sichuan pepper is still called for in many traditional Chinese recipes.',7.99,4,48,'Beef, chicken, shrimp, fish, pho, soups', 'Chinese and Far Eastern');
INSERT INTO Spices VALUES('Sriracha Powder','Everyone’s favorite fiery Asian sauce, now in a convenient dry form! Perfect for sprinkling onto popcorn or homemade potato chips, or adding to dips and sauces. Shake a little onto scrambled eggs or dust onto grilling veggies, or anywhere you want that sweet, tangy heat!',7.99,4,49,NULL, 'Chinese and Far Eastern, Thai');
INSERT INTO Spices VALUES('Star Anise, Whole','Whole, perfect Star Anise are really quite a beautiful wonder of nature, with eight points and a seed in each point. Costly because they are picked out by hand, they are often reserved for craft use, although they make an attractive dinner garnish. They also add a lovely flavor and appearance floating in a cup of tea. For you crafters, each ounce contains approximately 15 whole stars.',14.99,4,50,'duck, eggs, fish, leeks, pastry, pears, pork, poultry, pumpkin, shrimp', 'Chinese and Far Eastern, Thai');
INSERT INTO Spices VALUES('Wasabi Powder','Wasabi is a variety of green horseradish, the powder has a sharp flavor thats a bit hotter than the familiar white horseradish.  Wasabi powder provides a nice change of pace from chiles. It provides heat, but has more of an herbal overtone and dissapates more quickly. You can also use it as a substitute for Dijon mustard, or as a flavoring in home-made mustards.',4.69,4,51,'sashimi, sushi, mayonnaise, potatoes', 'Chinese and Far Eastern');
INSERT INTO Spices VALUES('Caraway Seeds, Whole','Caraway seeds are on the shopping list for most of our German customers.  This traditional taste is used in sauerkraut, coleslaw, goulash, stews, cheese, rye bread, seed cake, pork roast, and fish & shrimp boil.',6.99,16,52,'sauerkraut, coleslaw, goulash, stews, cheese, rye bread, pork, fish, shrimp', NULL);
INSERT INTO Spices VALUES('Celery Seed, Whole','Celery seeds most popular usage is in coleslaw and potato salads.  Celery seed is a small, somewhat bitter, seed often found as an ingredient in cold vegetable salads, sauerkraut and pickling.',6.29,8,53,'vegetable salads, sauerkraut, spice rubs, fish');
INSERT INTO Spices VALUES('Nigella Sativa Charnushka','Charnuska is used in traditional Lebanese,Indian, Serbian, and Armenian cuisines.  Also known as Black Cumin, Black Caraway seed, or Black Onion seed, this flavorful small black seed is often used in Jewish rye bread, flatbreads and savory pastries. It is also mixed with other seeds, such as mustard, cumin, fennel and fenugreek to make up a blend known as panch phoron which is used in Benal cooking for beans and vegetables dishes. Known Kolonji in India, this seed is an ingredient in many curry and garam masala recipes.',6.29,8,54,'curry, rye bread, pastry', 'Eastern European, Indian');
INSERT INTO Spices VALUES('Dill Seed','Dill seeds most common use, in the United States, is to flavor cucumber pickles. Use 2-3 teaspoons per quart for dill pickles. These seeds are also used in Scandinavian cooking to flavor bread, potatoes, vegetables, sauerkraut. For German pork roast, use 1 teaspoon per pound of meat.',2.99,4,55,'beets, breads, cabbage, carrots, chicken cucumbers, cream sauces, eggs, fish, pickles, potatoes, salmon, scallops, seafood, sour cream, tomatoes, veal', 'Eastern European, German, Scandinavian');
INSERT INTO Spices VALUES('Horseradish Powder','Add horseradish powder to any sauce and give it a sharp zippy flavor.  The volatile oils which give horseradish its pungent nature are quite similar to those found in mustard. When you cook horseradish, these oils evaporate, reducing the bite. This is why you normally see horseradish used in uncooked sauces.',5.29,8,56,'sauces, spreads', 'Eastern European');
INSERT INTO Spices VALUES('Juniper Berries','Juniper berries are used primarily to flavor wild game.  Due to the many hunters among our customers, juniper berries have always been in great demand at the peak of the game season. Their flavor was popular with the American Indians in the Pacific Northwest, who crushed the berries and cooked them with wild buffalo. They have a tart flavor which cuts back some of the gaminess of venison. In European countries, juniper berries are a necessity for marinades for wild boar, venison, and pork dishes; and are often used in stuffing for all types of fowl. They may be thrown in a stew, whether beef or rabbit, and, of course, you cannot make an authentic sauerbraten without the addition of juniper berries. Try a few in your sauerkraut, too!',7.99,4,57,'Wild game, stews, sauerkraut', 'Eastern European, German, Irish');
INSERT INTO Spices VALUES('Mustard Seed, Crushed Brown','Crushed brown mustard seeds are called Bavarian-style mustard. These brown mustard seeds are nice for making a sharp tasting coarse mustard paste, which goes well with brats and kraut.',3.99,8,58,'bratwurst, sauerkraut, mustard','European, German, Indian');
INSERT INTO Spices VALUES('Granulated Onion',' Onion powder is a great way to add onion flavor (and your kids wont know its there). No more crying in the kitchen! Easily add a bit of onion flavor to any dish, with one shake of a jar.',5.29,8,59,'dips, sauces, rice, chili', 'Eastern European');
INSERT INTO Spices VALUES('Paprika, Hungarian Sweet','Sweet Hungarian paprika is perfect for your favorite goulash or deviled eggs. Fresh paprika has a full, sweet pepper flavor without the heat. Its not just a pretty garnishing color!',6.69,8,60,'Deviled Eggs, potatoes, chicken, fish, goulash','Eastern European, Greek and Turkish, Hungarian');

-- 61-80
INSERT INTO Spices VALUES('White Malaysian Pepper, Ground ','White peppercorns come from the same vine as the black. They are soaked in water, which softens the shells, whereupon the shells are removed. Their flavor, while still distinctly pepper, is quite different from that of black peppercorns. The soaking gives this pepper a mellow, slightly fermented taste. White pepper is strongly preferred over black pepper in European kitchens. In this country we consume about twelve times as much black pepper as white, while in Europe the ratios are reversed. This finely powdered white Malaysian pepper virtually disappears in most dishes, allowing the introduction of fine flavor without marring the presentation of light-colored sauces and dishes',8.00,10.79,61,'Eastern European, Germany');
INSERT INTO Spices VALUES('Poppy Seeds, Dutch Blue Whole','Dutch blue poppy seed is useful for baking bread.  This high-quality Holland, A-1 Extra Fancy poppy seed has become increasingly difficult to find in recent years. Our Dutch poppy seed has a very fresh, nutty flavor.', 8.00 , 5.29,62, 'breads, curries, fruit, noodles, rice' ,'Eastern European, English');
INSERT INTO Spices VALUES('English Prime Rib Rub','Dutch blue poppy seed is useful for baking bread.  This high-quality Holland, A-1 Extra Fancy poppy seed has become increasingly difficult to find in recent years. Our Dutch poppy seed has a very fresh, nutty flavor.', 4.00, 4.69,63,'beef, pork and Bloody Marys','English');
INSERT INTO Spices VALUES('Lavender Flower Buds', ': Lovely, floral lavender is a unique ingredient to use in baking. You may choose to use these lavender flower buds in cooking or in a potpourri craft project.', 4.00 , 4.69,64, 'sauces, wines, teas, cookies, custard, ice cream', 'English, French');
INSERT INTO Spices VALUES('Lemon Peel Zest','Lemon Peel is an intensely flavored dehydrated lemon zest that will save you time in your baking activities.', 4.00, 9.19,65, 'fish, shrimp, rice, vegetables, custard, ice cream, cookies, sauces', 'English');
INSERT INTO Spices VALUES('Sage, Broken Leaf ','Sage has a very pungent flavor, requiring only small quantities for good seasoning. Sage is most popularly used in turkey stuffing, although stuffings for goose, chicken and duck also benefit from this seasoning. With our strong German and Slavic populations in the Midwest, many folks still practice the art of sausage making; we sell a lot of sage for this purpose. Sage marries very nicely with pork; it makes a nice salt-free rub for pork roast.', 4.00, 6.99,66,'duck, eggplant, fish, game, goose, liver, peas, pork, poultry, ravioli, roasts, stuffings, tomatoes, tuna, veal, apple, cheese, beans', 'English');
INSERT INTO Spices VALUES('Spearmint Leafs','Spearmint is the mint used most often in cooking. The Romans introduced spearmint to the English, who use it both as a summer herb flavor for fresh garden vegetables, and to make the well-known mint jelly or mint sauce which traditionally accompanies roast lamb or mutton dishes. It’s also used in Pimms No. 1 Cup. In India, many chutneys begin with the grinding of coconut and mint. Usually mint is considered to pair well with lamb, duck, chicken, pork or veal in the meat department. Many vegetables dishes benefit from the addition of mint, as do Asian dipping sauces, beans, lentils and tabbouleh. It adds just the right refreshing touch to fruits and fruit salads. As far as drinks go, one would never make a mint julep or a mojito without mint, the additional of mint is why they are so refreshing.', 4.00, 6.99, 67,'carrots, chocolate, duck, eggplant, fruit, goat, ice cream, lamb, lentils, oranges, peas, peppers, pilafs, pork, salsas, tomatoes, vegetables, yogurt', 'English, Greek, Turkish, Irish, Middle Easter.');
INSERT INTO Spices VALUES('Chervil','Chervil is similar to parsley, enhanced by a touch of anise flavor. This dehydrated French chervil has a beautiful deep green color as well as a delicate, pleasant flavor.', 4.00, 7.99,68, 'asparagus, carrots, cheese, chicken, eggs, fish, peas, potatoes, salads, sauces, soups, spinach, tomatoes, veal, venison', 'French');
INSERT INTO Spices VALUES('Lavender Vanilla Sugar','Lavender Vanilla Sugar adds a subtle floral touch to baked goods, tea, toast or muffins. It is perfect for delicate desserts for brunch or high tea. The flavor is a particularly nice compliment with chocolate; try it on hot chocolate or brownies', 6.00, 10.99,69,'Custards, hot chocolate, borwnies, tea, ice cream','French');
INSERT INTO Spices VALUES('Herbes de Provence','Herbes de Provence is the classic French herb blend.  Also known as Provencal herbs, this delightful mixture takes its name from the region of Provence, France. The people of Provence have an abundance of fresh herbs growing in their backyards, and understand the subtleties that the flavor of these herbs lend to the wonderful fresh vegetables, meat and fish available to them. A very unusual ingredient must be included to make this really worthy of Provence: lavender from the same region. This salt-free, country-style blend really adds something to any dish -- beef or rabbit stew, roast lamb, chicken, pork, soups and stocks, vegetable dishes (especially eggplant or zucchini), tomatoes. Hand mixed from: rosemary, French thyme, tarragon, basil, savory, cracked fennel, lavender, marjoram, oregano, dill and chervil.', 4.00, 9.19, 70, 'Beef, rabbit, lamb, chicken, pork, stew, soup, stocks, tomatoes, zucchini, eggplant', 'French');
INSERT INTO Spices VALUES('Fleur de Sel "Espirt de Sel" (French Sea Salt)','This salt has been harvested by hand on the Atlantic island of Re, France, since the 7th century. Gathered in summer, and smelling of the sea and violets, this fine white natural seasoning adds bright aroma and flavor to food. The Esprit du Sel brand is your guarantee of purity and the most intense sea salt produced in France.', 6.00, 14.29, 71, 'French');
INSERT INTO Spices VALUES('Shallots','Shallots are a member of the onion family, often described as a cross between onion and garlic. Their flavor is light, sweet and delicate, and we have not found many dishes which are not enhanced by tossing in some of these freeze-dried shallots', 1.00, 8.99, 72, 'Chicken, fish, beef, pork, omelets, dressings shrimp, scallops, crab', 'French');
INSERT INTO Spices VALUES('Tarragon', 'French Tarragon, also known as estragon, is often used in salad dressings, especially vinaigrettes, and in flavoring mustards and mayonnaise. It is commonly used for making herb butters, and added to many cream soups.', 4.00, 13.49, 73, 'artichokes, bearnaise sauce, carrots, chicken, eggs, fish, lobster, mushrooms, onions, potatoes, rabbit, salads, shellfish, sole, spinach, stuffings, tomatoes, veal', 'French');
INSERT INTO Spices VALUES('Thyme, French Select', 'Thyme is a great herb for everyday cooking. French Select Thyme has a deep green color and a fresh, smooth aroma. It is a sweeter flavor and softer leaf than the standard Mediterranean thyme.', 4.00, 9.19, 74, 'beef, carrots, chicken, figs, fish, goat cheese, lamb, lentils, onions, peas, pork, potatoes, soups, tomatoes, venison', 'French, Hungarian');
INSERT INTO Spices VALUES('Ajown Seeds', 'Ajowan seed is also known as Ajwain seed and Carom. This spice is popular in southern Indian style cooking. It has a flavor reminiscent of thyme; a similarity due to the presence of the essential oil thymol in both. These seeds are used in Asian cooking, breads, biscuits, savory pastries, and in bean dishes. This spice closely resembles the Lovage seed.', 8.00, 7.99, 75, 'Bread, beans, biscuits, curry', 'Greek, Turkish, Indian');
INSERT INTO Spices VALUES('Dill Weed', 'Dill Weed is a bright, tasty addition to dips and dressings, omelets, white sauces and soups. Today''s dehydration process keeps the dill weed exceptionally green and flavorful, making it a colorful addition to many dishes. Its flavor is light and sweet, and because of this it is often added to a dish just before serving to preserve the flavor. The dill herb is popular in Greek, Turkish and Slavic cuisines for dishes containing mushrooms or spinach, chicken casseroles, and with lamb. Among the German-American population, it is commonly used with poultry, fish, egg and cheese dishes.', 4.00, 5.29,76, 'spinach, mushrooms, chicken, lamb, fish, eggs, cheese', 'Eastern European, Greek and Turkish, Scandinavian');
INSERT INTO Spices VALUES('Oregano, Greek', 'Greek oregano has a bright, sweet flavor which we associate with Italian-style cooking. Its clean, lemony overtones blend well with Mediterranean dishes.', 4.00, 6.99, 77, 'artichokes, beans, chicken, eggplant, fish, lamb, mushrooms, pasta, peppers, pizza, pork, potatoes, rabbit, sausages, tomatoes, veal, zucchini', 'Greek and Turkish');
INSERT INTO Spices VALUES('Thyme, Broken Leaf Mediterranean ', 'Mediterranean Thyme, Broken Leaf is a great herb for every day cooking. We currently have several varieties of thyme available. The Mediterranean thyme (also called "European thyme") is the variety most commonly found.  Heavier dishes, in general, benefit particularly from thyme. Add it to soups, stews, clam chowder, stuffing, gumbos, heartier sauces, roast chicken or pork, many vegetable dishes, or fish. Thyme is an essential ingredient in any Bouquet Garni.', 4.00, 6.99, 78, 'beef, carrots, chicken, figs, fish, goat cheese, lamb, lentils, onions, peas, pork, potatoes, soups, tomatoes, venison', 'Greek and Turkish, Hungarian');
INSERT INTO Spices VALUES('Urfa Biber Turkish Chile Pepper', 'Commonly called for in Turkish cooking, urfa biber is a rich, fruity crushed pepper that’s delicious in all kinds of dishes. It’s got a little kick of heat, with a tangy, raisin-y taste that compliments roast vegetables and meats, fruit dishes, and sweet baking spices like vanilla and chocolate. Urfa peppers are picked when they ripen to bright red, then cured for a week to develop their characteristic deep purple color and smoky, earthy flavor', 4.00, 5.59, 79, NULL);
INSERT INTO Spices VALUES('Paprika, Smoked Sweet Spanish ', 'Spanish Smoked Sweet Paprika is also known as Pimenton de la Vera, Dulce. It is a popular ingredient in many Mediterranean recipes. Anyone from Spain swears by this paprika, and its flavor is essential for authentic Spanish cooking. The peppers are dried slowly over an oak burning fire for several weeks. The result is a sweet, cool, smoky flavor. Popular for dishes such as gratin of leafy greens and crispy potatoes, fish dishes, spinach and chickpea stew or bean dishes. Excellent on grilled veggies or corn on the cob. A great way to add a smoky flavor with no heat.', 4.00, 5.59, 80, 'cauliflower, chicken, crab, fish, goulash, lamb, potatoes, rice, shellfish, stroganoff, veal, beans.', 'Greek and Turkish, Hungarian, Middle Eastern, Spanish');


-- 81-100
INSERT INTO Spices VALUES('Paprika, Smoked Hot Spanish','Spanish Smoked Hot Paprika ia also known as Pimenton de la Vera, Picante. It is a popular ingredient in many Mediterranean recipes, and essential to Spanish cuisine. The peppers are dried slowly over an oak-burning fire for several weeks. The result is a hot, smoky flavor. Try it in soups or chorizo. Add it to garlic flavored mayonnaise, which can then be used as a spread for grilling chicken or fish. Use it to make your deviled eggs truly sinister.',5.59,4,81,'cauliflower, chicken, crab, fish, goulash, lamb, potatoes, rice, shellfish, stroganoff, veal, beans','Hungarian, Spanish');
INSERT INTO Spices VALUES('Corned Beef Blend of Whole Spices','Corned Beef Spice was specifically designed for marinating beef brisket. Use 3-5 tablespoons for a 5-pound brisket, along with salt brine. This is a popular blend for St. Patrick’s Day celebrations.  Hand-mixed from mustard seeds, Moroccan coriander, Jamaican allspice, Zanzibar cloves, Turkish bay leaves, Indian dill seed, China #1 ginger, star anise, black pepper, juniper berries, mace and cayenne red pepper',4.69,4,82,'brisket','Irish');
INSERT INTO Spices VALUES('Baharat Seasoning','Baharat means spices in Arabic, and this wonderfully complex blend has a unique balance of spicy flavors. Savory and slightly sweet, with a lingering heat, this can be an all-purpose blend with a definite Middle Eastern twist.  Baharat blend is often used in the Persian Gulf area to add spice and a little heat to ground meat dishes, couscous, vegetables & vegetable stuffing, and Tunisian egg tagines. The sublty exotic flavors of this blend are wonderful for MedRim style cooking, and an easy way to spice up simple dishes like rice and meatballs',5.59,4,83,'lamb, pork, beef, chicken, couscous, stuffing','Middle Eastern');
INSERT INTO Spices VALUES('Ras El Hanout','Ras El Hanout translates to "top of the shop", and represents the best blend a spice merchant has to offer. This is a traditional Arabic blend, common to Muslim and Sephardic cuisines, made with the spices their culture prefers. Hand mixed from: Tellicherry black pepper, cardamom, Baleine salt (Sea Salt, anticaking agents:magnesium carbonates, magnesium oxide, yellow prussiate of soda), ginger, cinnamon, mace, turmeric, allspice, nutmeg, and saffron.',9.19,4,84,'meatballs, lamb, potatoes, beef','Middle Eastern');
INSERT INTO Spices VALUES('Sumac','Sumac has a tart flavor that is very nice sprinkled on fish, chicken, over salad dressings, rice pilaf, or over raw onions. Try substituting in any dish on which you might squeeze fresh lemon juice. If you enjoy hummus, try topping it with a sprinkling of sumac. It’s delightful!  Sumac is considered essential for cooking in much of the Middle East; it served as the tart, acidic element in cooking prior to the introduction of lemons by the Romans. Sumac has a very nice, fruity-tart flavor which is not quite as overpowering as lemon. In addition to their very pleasant flavor, flakes from the berry are a lovely, deep red color which makes a very attractive garnish.',9.99,8,85,'fish, chicken, rice','Middle Eastern');
INSERT INTO Spices VALUES('Orange Peel Zest','Our orange peel is just as tangy as freshly grated zest, and far less work. These extra fancy California small minced pieces offer exceptional flavor and color.  Orange peel granules are the outer peel of the orange, not the pith, or white part, of the rind. To use, you only need add a third of what your recipe calls for in fresh peel. To rehydrate, add three parts water to one part peel and let stand 15 minutes (this is rarely necessary).',4.69,4,86,'Bread, cookies, biscotti, cheesecake, rice, tea','Scandinavian');
INSERT INTO Spices VALUES('Cardamom, White','When cardamom, a native of India, was first introduced to Scandinavia, it had to survive a lengthy sea voyage before reaching markets. The long exposure to sun, salt and air bleached the pods white and slightly altered the flavor of the seeds. Traditional Scandinavian recipes will still call for the bleached pods in pastries, breads and glögg, although you can certainly substitute green pods for a stronger, fresher flavor.',12.99,4,87,'chicken, coffee, curries, duck, lentils, meat, oranges, peas, rice, squash','Scandinavian');
INSERT INTO Spices VALUES('Curry Powder, Thai','Thai Curry Powder is a dry red powder that can easily be transformed into a paste by mixing it with water or fish sauce to the desired consistency. Thai blend hand mixed from: Chile pepper, garlic, lime peel, galangal, coriander, lemon grass, black pepper, cumin, fennel, mace and shallots.',10.79,8,88,'curry',NULL);
INSERT INTO Spices VALUES('Lemon Grass, Dried Chopped',' Lemon Grass is an essential ingredient in many Asian cuisines.  Fresh lemon grass should always be your first choice, but unless you live in a city with ethnic markets or Asian grocery stores, this is not always an option. Dried lemon grass has the advantage of a much longer shelf life. So, it won’t wilt in the refrigerator before you use it again.',3.49,1,89,'chicken, fish, pork, shellfish, soups','Thai');
INSERT INTO Spices VALUES('Garam Masala Curry Mixture, Ground','Garam Masala is a Punjabi, or Northern Indian, style curry powder. Garam Masala is based, not on turmeric, as are other curry powders, but on a tripart mixture of cardamom, coriander and black pepper.',9.19,4,90,'chicken, beef, lamb, shrimp, fish, ice cream, curry','Indian');
INSERT INTO Spices VALUES('Green Mysore Peppercorns','These dehydrated green peppercorns have a sharp, crisp flavor.  Green peppercorns come from the same vine as the black. The berries are picked earlier in the ripening process. They have a zesty, perky bite to them, quite different from the black berries.  Green pepper is essential to a majority of French cooking.',12.99,4,91,NULL,NULL);
INSERT INTO Spices VALUES('Japanese Seven Spice, Shichimi Togarashi','This is one of the most popular seasonings for a table condiment in Japan. With the ever expanding appreciation of Japanese cuisine here in this country, we realized it was necessary to incorporate the seasonings needed to create and enhance them as well. This seasoning is popular in Japan and used to add both heat and flavor to dishes such as soba noodles, udon, beef tataki, jasmine rice. We were sort of surprised by the heat of this seasoning, as traditionally Japanese cooking is not known to be fiery. Hand mixed from orange peel, black, white and toasted sesame seeds, cayenne, ginger, Szechuan pepper and nori.',9.99,8,92,'soba noodles, udon, beef, rice','Chinese and Far Eastern');
INSERT INTO Spices VALUES('Salt, Kosher Flake ','Kosher salt is inexpensive and great for everyday cooking and baking! It is preferred over table salt for canning and pickling. Like pickling salt, Kosher salt is free of iodine, which can react adversely with certain foods. Since it’s not as dense as pickling salt you’ll need to use more, but it varies by brand. For best results, it’s best to measure by weight rather than volume to avoid this problem.',3.99,48,93,NULL,NULL);
INSERT INTO Spices VALUES('Za’atar','Za’atar (zaatar) is a mixture of sumac, sesame seed and herbs frequently used in the Middle East and Mediterranean areas.  It is often mixed with olive oil and spread on bread; sometimes this is done at the table, other times the mix is spread on the bread rounds which are then baked. Za’atar also serves as a seasoning to sprinkle on vegetables, salads, meatballs or kebabs. Much like sausage seasonings, each country has a distinctive style of Za’atar, and each family develops its own special blend. Our particular blend is Israeli in style.  Hand mixed from sumac, thyme, sesame seeds, hyssop, and oregano.',5.59,4,94,'vegetables, meatballs, kebabs, salads','Middle Eastern');
INSERT INTO Spices VALUES('Mustard Powder, Regular','This regular mustard powder has a bit of heat.  This would be the mustard powder most similar to the English Coleman’s mustard. Use mustard powder to add a tangy kick to salad dressings, sauces, potato or tuna salad, and to make your own mustard.',3.99,8,95,'spice rubs, mustard, beef, sauces, salads','English, German');
INSERT INTO Spices VALUES('Tandoori Seasoning','Tandoori originally referred to cooking food by slow-roasting it in a clay oven, or tandoor. In the West, tandoori has come to mean a specific flavor rather than a method of cooking. Even if you do not have a clay oven or pot, you can use this seasoning to make tandoori-style chicken or other poultry. Rub this blend directly on meat, or mix with plain yogurt for a marinade. Delicious for seasoning lamb or beef kabobs. Hand-mixed from: coriander, cumin, garlic, paprika, ginger, cardamom, and saffron.',8.29,4,96,'beef, lamb, chicken, shrimp','Indian');
INSERT INTO Spices VALUES('Quebec Beef Spice','Quebec Beef Spice is one of our best blends for beef or pork. This traditional coarse-ground French-Canadian roasting spice mixture is great on pork or beef roast, but pairs well with chicken or turkey too. Use these spices to coat prime rib roast. This blend closely resembles another spice blend commonly known as Montreal Seasoning. Hand mixed from: coarse salt, cracked black Tellicherry pepper, sugar, minced garlic, white pepper, and cracked coriander seed. These simple flavors are simply gratifying.',9.29,8,97,'Beef',NULL);
INSERT INTO Spices VALUES('Rosemary Needles, Organic','Rosemary keeps its flavor better when dried than almost any other herb, and this organic rosemary is no exception. French, Spanish and Italian cultures use rosemary in abundance in their cooking. It has also gained a place in American cooking, primarily for lamb and chicken. Rosemary blends well in tomato sauces, soups or stews, or foccacia bread.',6.99,4,98,'Lamb, chicken, sauces, soup, stew, bread',NULL);
INSERT INTO Spices VALUES('Parisian Bonnes Herbes French Herb Blend','Parisian Bonnes Herbes is a light, delicate blend that’s great for fish, seafood, vegetables, or salad dressings. Hand mixed from: French tarragon, chervil, basil, dill, chives, and ground Muntok white pepper.',7.99,4,99,'fish, scallops, shrimp, vegetables, chicken, soups, sauces','French');
INSERT INTO Spices VALUES('White Truffle Oil','White truffle oil is Italian olive oil infused with rare white truffles. Use as you would any upscale olive oil, just anticipate the lovely addition of the truffle bouquet. We also carry black truffle oil. This is a luxurious flavored oil that high end foodies are sure to enjoy. It can be used in the same manner as any upscale olive oil. The truffle flavor is an added bonus.  The truffle is a tuber of unusual flavor and aroma savored in Italian and French cookery. The truffle has yet to be successfully cultivated and its scarcity commands a high price. Due to their short growing season and high demand, truffles can sell for up to $800 per pound.The truffles of Piedmont are especially prized for their exceptional flavors.',12.95,2,100,'chicken, grits, steak, risotto, salads ,bread, gnocchi, pizza, vegetables, eggs','Italian');

-- Category TABLE
INSERT INTO Category VALUES ('Indian');
INSERT INTO Category VALUES ('Middle Eastern');
INSERT INTO Category VALUES ('Thai');
INSERT INTO Category VALUES ('Scandinavian');
INSERT INTO Category VALUES ('Cajun');
INSERT INTO Category VALUES ('Mexican');
INSERT INTO Category VALUES ('Spanish');
INSERT INTO Category VALUES ('Greek and Turkish');
INSERT INTO Category VALUES ('Eastern European');
INSERT INTO Category VALUES ('Caribbean');
INSERT INTO Category VALUES ('Italian');
INSERT INTO Category VALUES ('English');
INSERT INTO Category VALUES ('German');
INSERT INTO Category VALUES ('Irish');
INSERT INTO Category VALUES ('Hungarian');
INSERT INTO Category VALUES ('Chinese and Far Eastern');
INSERT INTO Category VALUES ('French');

--Spice_Category TABLE
INSERT INTO Spice_Category VALUES (1, 'Indian');
INSERT INTO Spice_Category VALUES (1, 'Thai');

INSERT INTO Spice_Category VALUES (2, 'Indian');

INSERT INTO Spice_Category VALUES (3, 'Indian');
INSERT INTO Spice_Category VALUES (3, 'Middle Eastern');
INSERT INTO Spice_Category VALUES (3, 'Scandinavian');

INSERT INTO Spice_Category VALUES (4, 'Indian');
INSERT INTO Spice_Category VALUES (4, 'Cajun');

INSERT INTO Spice_Category VALUES (5, 'Indian');
INSERT INTO Spice_Category VALUES (5, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (5, 'Mexican');
INSERT INTO Spice_Category VALUES (5, 'Spanish');
INSERT INTO Spice_Category VALUES (5, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (6, 'Indian');
INSERT INTO Spice_Category VALUES (6, 'Eastern European');
INSERT INTO Spice_Category VALUES (6, 'English');
INSERT INTO Spice_Category VALUES (6, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (6, 'Mexican');
INSERT INTO Spice_Category VALUES (6, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (7, 'Indian');
INSERT INTO Spice_Category VALUES (7, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (7, 'Mexican');
INSERT INTO Spice_Category VALUES (7, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (8, 'Indian');

INSERT INTO Spice_Category VALUES (9, 'Indian');

INSERT INTO Spice_Category VALUES (10, 'Indian');

INSERT INTO Spice_Category VALUES (11, 'Indian');
INSERT INTO Spice_Category VALUES (11, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (11, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (12, 'Indian');
INSERT INTO Spice_Category VALUES (12, 'English');

INSERT INTO Spice_Category VALUES (13, 'Mexican');

INSERT INTO Spice_Category VALUES (14, 'Mexican');
INSERT INTO Spice_Category VALUES (14, 'Middle Eastern');
INSERT INTO Spice_Category VALUES (14, 'Greek and Turkish');

INSERT INTO Spice_Category VALUES (15, 'Mexican');
INSERT INTO Spice_Category VALUES (15, 'Caribbean');

INSERT INTO Spice_Category VALUES (16, 'Mexican');

INSERT INTO Spice_Category VALUES (17, 'Mexican');

INSERT INTO Spice_Category VALUES (18, 'Mexican');

INSERT INTO Spice_Category VALUES (19, 'Mexican');

INSERT INTO Spice_Category VALUES (20, 'Mexican');
INSERT INTO Spice_Category VALUES (20, 'English');
INSERT INTO Spice_Category VALUES (20, 'Middle Eastern');
INSERT INTO Spice_Category VALUES (20, 'Scandinavian');

INSERT INTO Spice_Category VALUES (21, 'Mexican');

INSERT INTO Spice_Category VALUES (22, 'Mexican');

INSERT INTO Spice_Category VALUES (23, 'Mexican');

INSERT INTO Spice_Category VALUES (24, 'German');
INSERT INTO Spice_Category VALUES (24, 'Italian');
INSERT INTO Spice_Category VALUES (24, 'Spanish');

INSERT INTO Spice_Category VALUES (25, 'Italian');

INSERT INTO Spice_Category VALUES (26, 'Italian');
INSERT INTO Spice_Category VALUES (26, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (26, 'Indian');

INSERT INTO Spice_Category VALUES (27, 'Italian');
INSERT INTO Spice_Category VALUES (27, 'Cajun');
INSERT INTO Spice_Category VALUES (27, 'Caribbean');
INSERT INTO Spice_Category VALUES (27, 'Eastern European');
INSERT INTO Spice_Category VALUES (27, 'Greek and Turkish');

INSERT INTO Spice_Category VALUES (28, 'Italian');

INSERT INTO Spice_Category VALUES (29, 'Italian');

INSERT INTO Spice_Category VALUES (30, 'Cajun');
INSERT INTO Spice_Category VALUES (30, 'Eastern European');
INSERT INTO Spice_Category VALUES (30, 'English');
INSERT INTO Spice_Category VALUES (30, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (30, 'Hungarian');
INSERT INTO Spice_Category VALUES (30, 'Irish');

INSERT INTO Spice_Category VALUES (31, 'Cajun');

INSERT INTO Spice_Category VALUES (32, 'Cajun');

INSERT INTO Spice_Category VALUES (33, 'Cajun');
INSERT INTO Spice_Category VALUES (33, 'Eastern European');
INSERT INTO Spice_Category VALUES (33, 'Greek and Turkish');

INSERT INTO Spice_Category VALUES (34, 'Cajun');

INSERT INTO Spice_Category VALUES (35, 'Caribbean');
INSERT INTO Spice_Category VALUES (35, 'Eastern European');

INSERT INTO Spice_Category VALUES (36, 'Caribbean');
INSERT INTO Spice_Category VALUES (36, 'Irish');

INSERT INTO Spice_Category VALUES (37, 'Caribbean');
INSERT INTO Spice_Category VALUES (37, 'Chinese and Far Eastern');
INSERT INTO Spice_Category VALUES (37, 'German');
INSERT INTO Spice_Category VALUES (37, 'Scandinavian');
INSERT INTO Spice_Category VALUES (37, 'Thai');

INSERT INTO Spice_Category VALUES (38, 'Caribbean');
INSERT INTO Spice_Category VALUES (38, 'Eastern European');
INSERT INTO Spice_Category VALUES (38, 'German');

INSERT INTO Spice_Category VALUES (39, 'Caribbean');
INSERT INTO Spice_Category VALUES (39, 'Eastern European');
INSERT INTO Spice_Category VALUES (39, 'English');

INSERT INTO Spice_Category VALUES (40, 'Caribbean');
INSERT INTO Spice_Category VALUES (40, 'Mexican');

INSERT INTO Spice_Category VALUES (41, 'Chinese and Far Eastern');
INSERT INTO Spice_Category VALUES (41, 'Indian');
INSERT INTO Spice_Category VALUES (41, 'Thai');

INSERT INTO Spice_Category VALUES (42, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (43, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (44, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (45, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (46, 'Chinese and Far Eastern');
INSERT INTO Spice_Category VALUES (46, 'German');

INSERT INTO Spice_Category VALUES (47, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (48, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (49, 'Chinese and Far Eastern');
INSERT INTO Spice_Category VALUES (49, 'Thai');

INSERT INTO Spice_Category VALUES (50, 'Chinese and Far Eastern');
INSERT INTO Spice_Category VALUES (50, 'Thai');

INSERT INTO Spice_Category VALUES (51, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (52, 'Eastern European');
INSERT INTO Spice_Category VALUES (52, 'German');
INSERT INTO Spice_Category VALUES (52, 'Hungarian');
INSERT INTO Spice_Category VALUES (52, 'Irish');
INSERT INTO Spice_Category VALUES (52, 'Scandinavian');

INSERT INTO Spice_Category VALUES (53, 'Eastern European');
INSERT INTO Spice_Category VALUES (53, 'German');
INSERT INTO Spice_Category VALUES (53, 'Hungarian');

INSERT INTO Spice_Category VALUES (54, 'Eastern European');
INSERT INTO Spice_Category VALUES (54, 'Indian');

INSERT INTO Spice_Category VALUES (55, 'Eastern European');
INSERT INTO Spice_Category VALUES (55, 'German');
INSERT INTO Spice_Category VALUES (55, 'Scandinavian');

INSERT INTO Spice_Category VALUES (56, 'Eastern European');

INSERT INTO Spice_Category VALUES (57, 'Eastern European');
INSERT INTO Spice_Category VALUES (57, 'German');
INSERT INTO Spice_Category VALUES (57, 'Irish');

INSERT INTO Spice_Category VALUES (58, 'Eastern European');
INSERT INTO Spice_Category VALUES (58, 'German');
INSERT INTO Spice_Category VALUES (58, 'Indian');

INSERT INTO Spice_Category VALUES (59, 'Eastern European');

INSERT INTO Spice_Category VALUES (60, 'Eastern European');
INSERT INTO Spice_Category VALUES (60, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (60, 'Hungarian');

INSERT INTO Spice_Category VALUES (61, 'Eastern European');
INSERT INTO Spice_Category VALUES (61, 'German');

INSERT INTO Spice_Category VALUES (62, 'Eastern European');
INSERT INTO Spice_Category VALUES (62, 'English');

INSERT INTO Spice_Category VALUES (63, 'English');

INSERT INTO Spice_Category VALUES (64, 'English');
INSERT INTO Spice_Category VALUES (64, 'French');

INSERT INTO Spice_Category VALUES (65, 'English');

INSERT INTO Spice_Category VALUES (66, 'English');

INSERT INTO Spice_Category VALUES (67, 'English');
INSERT INTO Spice_Category VALUES (67, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (67, 'Irish');
INSERT INTO Spice_Category VALUES (67, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (68, 'French');

INSERT INTO Spice_Category VALUES (69, 'French');

INSERT INTO Spice_Category VALUES (70, 'French');

INSERT INTO Spice_Category VALUES (71, 'French');

INSERT INTO Spice_Category VALUES (72, 'French');

INSERT INTO Spice_Category VALUES (73, 'French');

INSERT INTO Spice_Category VALUES (74, 'French');
INSERT INTO Spice_Category VALUES (74, 'Hungarian');

INSERT INTO Spice_Category VALUES (75, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (75, 'Indian');

INSERT INTO Spice_Category VALUES (76, 'Eastern European');
INSERT INTO Spice_Category VALUES (76, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (76, 'Scandinavian');

INSERT INTO Spice_Category VALUES (77, 'Greek and Turkish');

INSERT INTO Spice_Category VALUES (78, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (78, 'Hungarian');

INSERT INTO Spice_Category VALUES (79, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (79, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (80, 'Greek and Turkish');
INSERT INTO Spice_Category VALUES (80, 'Hungarian');
INSERT INTO Spice_Category VALUES (80, 'Middle Eastern');
INSERT INTO Spice_Category VALUES (80, 'Spanish');

INSERT INTO Spice_Category VALUES (81, 'Hungarian');
INSERT INTO Spice_Category VALUES (81, 'Spanish');

INSERT INTO Spice_Category VALUES (82, 'Irish');

INSERT INTO Spice_Category VALUES (83, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (84, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (85, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (86, 'Scandinavian');

INSERT INTO Spice_Category VALUES (87, 'Scandinavian');

INSERT INTO Spice_Category VALUES (88, 'Thai');

INSERT INTO Spice_Category VALUES (89, 'Thai');

INSERT INTO Spice_Category VALUES (90, 'Indian');

INSERT INTO Spice_Category VALUES (92, 'Chinese and Far Eastern');

INSERT INTO Spice_Category VALUES (94, 'Middle Eastern');

INSERT INTO Spice_Category VALUES (95, 'English');
INSERT INTO Spice_Category VALUES (95, 'German');

INSERT INTO Spice_Category VALUES (96, 'Indian');

INSERT INTO Spice_Category VALUES (99, 'French');

INSERT INTO Spice_Category VALUES (100, 'Italian');

INSERT INTO Orders(order_id) VALUES (0);

ALTER TABLE Spices DROP COLUMN category;