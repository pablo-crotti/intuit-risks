const groupEvaluationsByCompanyRiskId = (data) => {
    return data.reduce((acc, evaluation) => {
        if (!acc[evaluation.company_risk_id]) {
            acc[evaluation.company_risk_id] = [];
        }

        acc[evaluation.company_risk_id].push(evaluation);

        return acc;
    }, {});
};



const processData = (data) => {
    const riskHistory = {};
    const result = {};

    for (const date in data) {
        data[date].forEach((entry) => {
            entry.criticity = entry.probability * entry.impact;
            if (!riskHistory[entry.company_risk_id]) {
                riskHistory[entry.company_risk_id] = [];
            }
            riskHistory[entry.company_risk_id].push(entry);
        });
    }

    for (const riskId in riskHistory) {
        riskHistory[riskId].sort(
            (a, b) => new Date(a.created_at) - new Date(b.created_at)
        );
    }

    for (const riskId in riskHistory) {
        const entries = riskHistory[riskId];
        for (let i = 0; i < entries.length; i++) {
            const current = entries[i];
            let variation = 0;

            if (i > 0) {
                const previous = entries[i - 1];
                variation = current.criticity - previous.criticity;
            }

            if (!result[riskId]) {
                result[riskId] = [];
            }

            result[riskId].push({
                var: variation >= 0 ? `+${variation}` : `${variation}`,
                created_at: current.created_at,
            });
        }
    }

    return result;
};

const groupVariations = (data) => {
    const groupedVariations = {};
    Object.values(data)
        .flat()
        .forEach((entry) => {
            const date = entry.created_at.split("T")[0];
            const variation = parseInt(entry.var, 10);

            if (!groupedVariations[date]) {
                groupedVariations[date] = 0;
            }

            groupedVariations[date] += variation;
        });

    return groupedVariations;
}

const formatEvaluationsVariations = (data) => {
    const groupedEvaluations = groupEvaluationsByCompanyRiskId(data);
    const processedData = processData(groupedEvaluations);
    const groupedVariations = groupVariations(processedData);

    return groupedVariations;
}

export default { formatEvaluationsVariations };

