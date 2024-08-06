import ollama from "ollama"

/**
 * Sends a request to the Mistral model to get a response based on the provided message.
 *
 * @param {Object[]} message - The array of messages to send to the Mistral model.
 * @param {Object} message[] - An object representing a message in the conversation.
 * @param {string} message[].role - The role of the message, such as "system" or "user".
 * @param {string} message[].content - The content of the message.
 * @returns {Promise<Object>} The response from the Mistral model in JSON format.
 * @throws {Error} If an error occurs during the request.
 */
const askMistral = async (message) => {
    try {
        const completion = await ollama.chat({
            model: "mistral",
            response_format: { type: "json_object" },
            messages: message,

        });

        return JSON.parse(completion.message.content)
    } catch (error) {
        throw new Error("Une erreur est survenue, veuillez réessayer.");
    }
}
/**
 * Develops an emergency plan for a given crisis by providing key information and essential tasks.
 *
 * @param {Object} risk - The details of the crisis.
 * @param {string} risk.name - The name of the crisis.
 * @param {string} risk.description - The description of the crisis.
 * @param {Object[]} company - The details of the company.
 * @param {string} company.organization_type - The type of organization of the company.
 * @param {string} company.country - The country where the company is based.
 * @param {string} company.city - The city where the company is based.
 * @param {number} company.employees - The number of employees in the company.
 * @param {string} company.sector - The primary business sector of the company.
 * @param {Object[]} informations - The information already identified.
 * @param {string} informations[].information - An identified piece of information.
 * @param {Object[]} actions - The actions already identified.
 * @param {string} actions[].action - An identified action.
 * @returns {Promise<Object>} An emergency plan containing the crucial information and tasks to be completed, in JSON format.
 */
const askEmergencyPlan = async (risk, company, informations, actions) => {
    const message = [
        {
            role: "system",
            content: `Tu es spécialiste en gestion de crise dans une ${company.organization_type} ${company.country}, basée à ${company.city} de ${company.employees} employés. Le secteur d'activité principal de l'entreprise est : « ${company.sector} ». Tu es paramétré pour répondre en JSON et en français.`,
        }, {


            role: "user",
            content: `Pour développer un plan d'urgence, détermine les informations clés nécessaires pour comprendre la situation et liste les étapes essentielles pour y répondre efficacement. La crise en question est la suivante : « ${risk.name} ». La description du risque est la suivante : « ${risk.description} ». Les informations déjà identifiées sont les suivantes : ${informations.map(info => `${info.information}`).join(', ')}. Les actions déjà identifiées sont les suivantes : ${actions.map(action => `${action.action}`).join(', ')}. Génère un plan contenant uniquement les informations cruciales à obtenir et les tâches à accomplir pour gérer cette crise tout en essayant de garantir la continuité des activités. Donne tes réponses UNIQUEMENT dans le format JSON suivant : {"infos":[{"action": "Information 1"},{"action": "Information 2"},{"action": "Etc…"},],"tasks":[{"action": "Tâche 1"},{"action": "Tâche 2"},{"action": "Etc…"},]}`,
        }
    ];

    return await askMistral(message);
}


/**
 * Determines the most relevant precursors for a given crisis.
 *
 * @param {Object} risk - The details of the crisis.
 * @param {string} risk.name - The name of the crisis.
 * @param {string} risk.description - The description of the crisis.
 * @param {Object} company - The details of the company.
 * @param {string} company.organization_type - The type of organization of the company.
 * @param {string} company.country - The country where the company is based.
 * @param {string} company.city - The city where the company is based.
 * @param {number} company.employees - The number of employees in the company.
 * @param {string} company.sector - The primary business sector of the company.
 * @returns {Promise<Object>} A list of precursors for the crisis, in JSON format.
 */
const askPrecursors = async (risk, company) => {

    const message = [
        {
            role: "system",
            content: `Tu es spécialiste en gestion de crise dans une ${company.organization_type} ${company.country}, basée à ${company.city} de ${company.employees} employés. Le secteur d'activité principal de l'entreprise est : « ${company.sector} ». Tu es paramétré pour répondre en JSON et en français.`,
        },
        {
            role: "user",
            content: `Détermine les 4 signes avant coureurs les plus pertinents de la crise suivante : « ${risk.name} », ${risk.description}. Génère une liste de signes avant-coureurs de cette crise. Donne tes réponses UNIQUEMENT dans le format JSON suivant : {"precursors":[{"title": "Signe 1"},{"title": "Signe 2"},{"title": "Etc…"}]}`,
        }

    ]
    return await askMistral(message);
}
/**
 * Suggests a potential risk that has not yet been identified.
 *
 * @param {Object} company - The details of the company.
 * @param {string} company.organization_type - The type of organization of the company.
 * @param {string} company.country - The country where the company is based.
 * @param {string} company.city - The city where the company is based.
 * @param {number} company.employees - The number of employees in the company.
 * @param {string} company.sector - The primary business sector of the company.
 * @param {Object[]} risks - The risks already identified.
 * @param {string} risks[].name - The name of the risk.
 * @param {string} risks[].description - The description of the risk.
 * @param {Object[]} categories - The available categories.
 * @param {string} categories[].id - The ID of the category.
 * @param {string} categories[].label - The label of the category.
 * @param {string} categories[].name - The name of the category.
 * @param {string} categories[].color - The color of the category (hex code).
 * @returns {Promise<Object>} A new potential risk, in JSON format.
 */
const askRisk = async (company, risks, categories) => {

    const message = [
        {
            role: "system",
            content: `Tu es spécialiste en gestion de crise dans une ${company.organization_type} ${company.country}, basée à ${company.city} de ${company.employees} employés. Le secteur d'activité principal de l'entreprise est : « ${company.sector} ». Tu es paramétré pour répondre en JSON et en français.`,
        },
        {
            role: "user",
            content: `Donne moi un risque que l'on n'auraît peut être pas identifié. Voici les risques déjà identifiés : ${risks.map(risk => `${risk.name}: ${risk.description}`).join(', ')}. Voici les catégories que tu dois utiliser : ${categories.map(category => `[${category.id}, ${category.label}, ${category.name}, ${category.color}]`).join(', ')}. Donne tes réponses UNIQUEMENT dans le format JSON suivant : {"title": "Nom du risque","description": "Description du risque","category": {id: "X", label: "XXX", name: "Yyyyyy", color: "#xxyyzz"}}`

        }

    ]

    return await askMistral(message);
}

/**
 * Suggests a task to reduce a specific risk, avoiding tasks that have already been identified.
 *
 * @param {Object} company - The details of the company.
 * @param {string} company.organization_type - The type of organization of the company.
 * @param {string} company.country - The country where the company is based.
 * @param {string} company.city - The city where the company is based.
 * @param {number} company.employees - The number of employees in the company.
 * @param {string} company.sector - The primary business sector of the company.
 * @param {Object} risk - The details of the risk.
 * @param {string} risk.name - The name of the risk.
 * @param {string} risk.description - The description of the risk.
 * @param {Object[]} risk.reduction_plan_tasks - The tasks already identified to reduce the risk.
 * @param {string} risk.reduction_plan_tasks[].action - An identified task.
 * @returns {Promise<Object>} A new task to reduce the risk, in JSON format.
 */
const askReductionPlanTask = async (company, risk) => {
    const message = [
        {
            role: "system",
            content: `Tu es spécialiste en gestion de crise dans une ${company.organization_type} ${company.country}, basée à ${company.city} de ${company.employees} employés. Le secteur d'activité principal de l'entreprise est : « ${company.sector} ». Tu es paramétré pour répondre en JSON et en français.`,
        },
        {
            role: "user",
            content: `Donne moi une tâche à faire pour réduire le risque suivant : ${risk.name}, ${risk.description}. Les tâches déjà identifiées sont les suivantes : ${risk.reduction_plan_tasks.map(task => task.action).join(', ')}. Donne ta réponses qui ne soit pas semblable aux tâches déjà identifiées UNIQUEMENT dans le format JSON suivant : {"title": "Nom de la tâche"}`

        }

    ]

    return await askMistral(message);
}

export default { askPrecursors, askRisk, askReductionPlanTask, askEmergencyPlan }

