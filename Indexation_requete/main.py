import sys
import json
from indexation_plantes import *


if __name__ == "__main__":
    # Vérifier si un argument est fourni
    if len(sys.argv) > 1:
        word = sys.argv[1]
        # Appeler la fonction spécifique et renvoyer le résultat
        results =programme_affichage_par_ordre_de_pertinance(word)
        print(json.dumps(results))  # Retourner un JSON
    else:
        print(json.dumps({"error": "No input provided"}))