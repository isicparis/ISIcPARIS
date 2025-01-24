#pip install psycopg2-binary
import psycopg2

import time

start_time = time.time()

# Database URL
DB_URL = "postgresql://postgres:Isicparis_123@db.jzglofusihfqhmrmszho.supabase.co:5432/postgres"

# Connect to the database
try:
    conn = psycopg2.connect(DB_URL)
except Exception as e:
    print(f"Failed to connect: {e}")

except Exception as e:
    print(f"Failed to connect: {e}")
#Open a cursor to perform database operations
cur = conn.cursor()

# Execute a command: create datacamp_courses table
cur.execute("""SELECT * FROM Plantes;""")
liste=cur.fetchall()

#splitting the tags from string to a list of strings
# Transform the list
transformed_list = []
for item in liste:
    # Convert the comma-separated string into a list
    tags = item[11].split(',')
    
    # Create a new tuple with the transformed data
    new_item = item[:11] + (tags,) + item[12:] + (None, None)
    
    # Append the new tuple to the transformed list
    transformed_list.append(new_item)

liste = transformed_list


"""# Création de corpus"""

corpus={}
for i in range(len(liste)):
  corpus[liste[i][0]]=liste[i][1]+"/"+liste[i][2]+"/"+liste[i][3]+"/"+liste[i][4]+"/"+liste[i][5]+"/"+liste[i][7]+"/"+liste[i][12]+"/"+liste[i][13]+"/"+liste[i][14]+"/"+liste[i][15]+"/"+liste[i][16]+"/"+liste[i][19]+"/"+liste[i][20]+"/"+liste[i][21]+"/"+liste[i][22]+"/"
  l=liste[i][11]
  for j in l:
    corpus[liste[i][0]]=corpus[liste[i][0]]+j+"/"
  if (liste[i][17]):
    corpus[liste[i][0]]=corpus[liste[i][0]]+"florissante"+"/"
  else:
    corpus[liste[i][0]]=corpus[liste[i][0]]+"non florissante"+"/"
  if liste[i][18]:
    corpus[liste[i][0]]=corpus[liste[i][0]]+"toxique"+"/"
  else:
    corpus[liste[i][0]]=corpus[liste[i][0]]+"non toxique"


def creation_corpus():


  conn = psycopg2.connect(DB_URL)

  cur = conn.cursor()
  cur.execute("""SELECT * FROM Plantes;""")
  liste=cur.fetchall()
  corpus={}
  for i in range(len(liste)):
    corpus[liste[i][0]]=liste[i][1]+"/"+liste[i][2]+"/"+liste[i][3]+"/"+liste[i][4]+"/"+liste[i][5]+"/"+liste[i][7]+"/"+liste[i][12]+"/"+liste[i][13]+"/"+liste[i][14]+"/"+liste[i][15]+"/"+liste[i][16]+"/"+liste[i][19]+"/"+liste[i][20]+"/"+liste[i][21]+"/"+liste[i][22]+"/"
    l=liste[i][11]
    for j in l:
      corpus[liste[i][0]]=corpus[liste[i][0]]+j+"/"
    if (liste[i][17]):
      corpus[liste[i][0]]=corpus[liste[i][0]]+"florissante"+"/"
    else:
      corpus[liste[i][0]]=corpus[liste[i][0]]+"non florissante"+"/"
    if liste[i][18]:
      corpus[liste[i][0]]=corpus[liste[i][0]]+"toxique"+"/"
    else:
      corpus[liste[i][0]]=corpus[liste[i][0]]+"non toxique"
  return(corpus)

"""#Phase d'indexation :

***Importaion des bibliothéques ***
"""

import nltk
nltk.download("book")

"""**Prétraitement**: Tokenzation et filtration"""

#Importation des bibliothéques:
import nltk
nltk.download('punkt_tab')
from nltk.tokenize import  word_tokenize
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
stop_words = set(stopwords.words('french'))

#fontion qui filtre le corpus:
def filter_corpus(corpus):
  dict={}

  for doc in corpus:
    d=corpus[doc]
    tokens = d.lower().split("/")
    filtered_text = [w for w in tokens if not (w in stop_words or w==".")]
    dict[doc]=filtered_text

  return(dict)

filtered_corpus=filter_corpus(corpus)


"""***LEMMMATISATION***"""

#cette fonction nous permet de lemmatizer chaque mot(token) dor corpus
def lemmatizer(filtered_corpus):
  #definir le lemmatizer ps
  ps = PorterStemmer()
  #initialiser in corpus lemmatisé initialement vide
  lemmatized_corpus={}
  for doc in filtered_corpus:
      #initialiser in document lemmatisé
      lemmatized_doc=[]
      for w in filtered_corpus[doc]:
        #lemmatiser a chaque fois un mot de doc de corpus et l'ajouter au queu de la corpus lemmatisé
        lemmatized_doc.append(ps.stem(w))
      #ajouter le resultat au document de lemmatized_corpus
      lemmatized_corpus[doc]=lemmatized_doc
  return(lemmatized_corpus)

lemmatized_corpus=lemmatizer(filtered_corpus)


"""Phase d'attribution des poids"""

#pour calculer la frequence dun mot dans un document
def wordfk_doc(doc,word):
  all_words = []
  for w in lemmatized_corpus[doc]:
    all_words.append(w.lower())
  all_words = nltk.FreqDist(all_words)
  return(all_words[word])



#corpus de fréquence des mots
def wordfk_corp(filtered_corpus,word):
  tf={}
  for doc in filtered_corpus:
    tf[doc]=wordfk_doc(doc,word)
  return (tf)

#fontion d'affrichage de fréquence de mot dans chaque document de corpus
def affichage_tf(mot,corpus):
  d=wordfk_corp(corpus,mot)
  for doc in d:
    print("le nombre d'occurence de mot ",mot,"dans le document ",doc,"est :",d[doc])


def liste_de_doc_ayant_mot(corpus,word):
  liste=[]
  for doc in corpus:
    if word in corpus[doc] :
      liste.append(doc)
  return(liste)


"""*Calcule de poids*"""

def nombre_de_doc_ayant_mot(word,corpus):
  return(len(liste_de_doc_ayant_mot(lemmatized_corpus,word)))

import math

def poids_doc(doc, word, corpus):
    tft = wordfk_doc(doc, word)  # Fonction à définir pour obtenir le nombre d'occurrences de 'word' dans 'doc'
    N = len(corpus)  # Nombre total de documents dans le corpus

    fdt = len(liste_de_doc_ayant_mot(corpus, word))  # Nombre de documents contenant le mot 'word' # Nombre de documents contenant le mot 'word'

    if fdt == 0:
        Wt = 0
    else:
        idf = math.log(N / fdt)  # Calcul de l'idf
        if tft == 0:
            Wt = 0
        else:
            Wt = (1 + math.log(tft)) * idf  # Cas général

    return Wt

def aff_poids(corpus,mot):
  for doc in corpus:
    print("poids de ",doc,": ",poids_doc(doc,mot,corpus))
aff_poids(lemmatized_corpus,'vert')
end_time = time.time()
print(f"Temps de réponse : {end_time - start_time:.4f} secondes")

start_time = time.time()
mytexts = nltk.TextCollection(lemmatized_corpus.values())


def calc_tf_idf(word,doc):
  tf_idf=mytexts.tf_idf(word, lemmatized_corpus[doc])
  return(tf_idf)

def calcpoid(corpus,word):
  dictpoids={}
  for doc in corpus:
    dictpoids[doc]=calc_tf_idf(word,doc)
  return(dictpoids)



def doc_pert(lemmatized_corpus,word):
    d=calcpoid(lemmatized_corpus,word)
    p = max(d.values())
    d_inverse = {valeur: cle for cle, valeur in d.items()}
    if (p==0):
      docc=wordfk_corp(lemmatized_corpus,word)
      m=docc[1]
      for doc in docc:
        if (docc[doc]>=m):
          m=docc[doc]
          pert= str(doc)
      ch="le document le plus pertinant est : "+ pert
    else:
      ch="le document le plus pertinant est : "+str(d_inverse.get(p))
    return ch

def pertinance_par_ordre(corpus,word):
  d=calcpoid(corpus,word)
  liste_ordonnée=[(x,y) for x,y in sorted(d.items(),key=lambda x:x[1],reverse=True)]
  doc_pertinant_ordonnés=[]
  for i in range(len(liste_ordonnée)):
    if (liste_ordonnée[i][1]!=0):
      doc_pertinant_ordonnés.append(liste_ordonnée[i][0])
  return(doc_pertinant_ordonnés)


def affichage_par_ordre_de_pertinance(corpus,word):
  d=pertinance_par_ordre(corpus,word)
  for i in range (len(d)):
    print("document numéro ",i," : ",d[i])

affichage_par_ordre_de_pertinance(lemmatized_corpus,'vert')
end_time = time.time()
print(f"Temps de réponse : {end_time - start_time:.4f} secondes")
print(lemmatized_corpus)

import matplotlib.pyplot as plt
import numpy as np

# Données simulées
# doc_sizes = [100, 500, 1000, 5000, 10000]
# response_times = [0.1, 0.3, 0.5, 1.5, 3.0]  # Temps de réponse mesurés

# Nombre total de documents dans le dictionnaire
total_docs = len(lemmatized_corpus)

# Liste des clés (identifiants des documents)
keys = list(lemmatized_corpus.keys())
doc_sizes=[]
response_times_classique=[]
response_times_nltk=[]
step=30
# Parcourir par groupes de 10
for i in range(0, total_docs, step):
    # Extraire un sous-dictionnaire des 10 documents actuels
    subset = {key: lemmatized_corpus[key] for key in keys[i:i+step]}
    doc_sizes.append(i)
    start_time=time.time()
    aff_poids(lemmatized_corpus,'vert')
    end_time = time.time()
    response_times_classique.append(end_time - start_time)
    start_time=time.time()
    affichage_par_ordre_de_pertinance(lemmatized_corpus,'vert')
    end_time = time.time()
    response_times_nltk.append(end_time - start_time)
    # Traitez les 10 documents extraits
    
# Création du graphique

plt.plot(doc_sizes, response_times_classique, marker='o', label="Algorithme classique", color='blue')
plt.plot(doc_sizes, response_times_nltk, marker='s', label="Algorithme NLTK", color='red')

# Ajouter les labels, le titre et la légende
plt.xlabel("Nombre de documents")
plt.ylabel("Temps (secondes)")
plt.title("Comparaison des temps de réponse entre deux algorithmes")
plt.legend()
plt.grid()
plt.show()
