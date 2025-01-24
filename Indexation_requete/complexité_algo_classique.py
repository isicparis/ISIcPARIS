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

