import MistralClient from "@mistralai/mistralai";
import ollama from "ollama"

const mistral = new MistralClient(import.meta.env.VITE_MISTRAL_API_KEY);

/**
 * Sends a message to Mistral AI and returns the response.
 *
 * @param {Array<Object>} message - An array of message objects. Each object should have 'role' and 'content' properties.
 * @param {string} message.role - The role of the message sender (either 'system' or 'user').
 * @param {string} message.content - The content of the message.
 * @returns {Promise<Object>} A promise that resolves to the parsed JSON response from Mistral AI.
 * @throws {Error} Throws an error if there's a problem with the Mistral AI request.
 */
const askMistral = async (message) => {
    try {
        const completion = await mistral.chat({
            model: "mistral-small-latest",
            response_format: { type: "json_object" },
            messages: message,

        });
        return JSON.parse(completion.choices[0].message.content);
    } catch (error) {
        throw new Error("Une erreur est survenue, veuillez réessayer.");
    }
}

// const askMistral = async (message) => {
//     try {
//         const completion = await ollama.chat({
//             model: "mistral",
//             response_format: { type: "json_object" },
//             messages: message,

//         });

//         return JSON.parse(completion.message.content)
//     } catch (error) {
//         throw new Error("Une erreur est survenue, veuillez réessayer.");
//     }
// }

/**
 * Asks Mistral AI to establish an emergency plan for a given risk.
 *
 * @param {Object} risk - The risk object containing 'description', 'probability', and 'impact'.
 * @param {string} risk.description - The description of the risk.
 * @param {number} risk.probability - The probability of the risk (between 0 and 4).
 * @param {number} risk.impact - The impact of the risk (between 0 and 4).
 * @param {Object} companyInfos - The company information object containing 'employees'.
 * @param {number} companyInfos.employees - The number of employees in the company.
 * @returns {Promise<Object>} A promise that resolves to an object containing 'informations' and 'taches'.
 * @throws {Error} Throws an error if there's a problem with the Mistral AI request.
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

