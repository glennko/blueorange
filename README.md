# blueorange
A webapp for Allstate Connected Home Hackathon: http://connectedhome.devpost.com/
Use this web app to track your connected home safety score, and get an estimate of the home insurance

Big thanks to my team: Daniel Chen, Glenn Ko! It's great working with them.

We were inspired by how auto insurance companies have been adopting new techniques to determine risk. In particular, some insurance companies offer the ability to attach a chip to the computer in order to monitor driving habits. This data can be used to calculate the risk for a driver as well as keeping the driver aware of their own habits. So, we thought: why not have something similar to assess risk for costly home insurance claims. These include things such as theft, fire, and water damage. This risk score can be used by both insurance companies in order to provide appropriate premiums. Customers can use this knowledge in order to mitigate the factors of their own home, thus improving their insurance premium.

####What it does
The connected home would have lots of sensors placed throughout the house that are designed to assess the presence of activities that are seen as risks to insurance companies. These include factors such as open doors, triggering the fire alarm, and excess water on the floor. The application aggregates all this information in order to provide scoring on the monitored risk factors.

####How We built it
We decided what events we wanted to monitor and developed sensor schemes in order to monitor that data. The sensors pass the data to the web listener which then collects the data. We used a php buildkit in order to deploy php into our Cloud Foundry instance. The backend is primarily implemented in php. The php obtains the data that was collected by the web listener and puts them through various formulas to help us obtain the final risk scores.

####Challenges I ran into
We are all hardware engineers who have no familiarity with most of these web technologies. We felt that we spent more time than others getting the initial platform set up. We encountered a lot of difficulty in getting the Mongo client to work on our php build script. Even though our authentication details and URL were correct, the Mongo client could not be initialized properly. Eventually, we figured out a way to retrieve and parse the raw JSON data to get the information we needed.

####Accomplishments that I'm proud of
We were proud that we learned and implemented new technologies on a new platform that, as hardware engineers, we never encountered before. We developed our idea quickly, but ran into difficulties getting basic functionalities to work. However, in the end, we were able to achieve the image that we had envisioned in the beginning.

#### What I learned
We learned how to initialize and deploy cloud applications on a CloudFoundry instance using pivotal.io’s hosting. We also learned how to use some new things such as MongoDB, JSON, the A6 REST API

####What's next for Blue Orange
We want to enhance the functionality and accessibility by deploying a web app. We also want to implement more sensors and more formulas in order to generate further data that could be interesting to users. Eventually, we want to have logins for different users so they can each view their own personalized data.

**Built With**: php, json, cloud-foundry, mongodb,a6

**Try it out**: [blueorange.cfapps.io](blueorange.cfapps.io)
