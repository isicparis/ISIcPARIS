# -*- coding: utf-8 -*-
"""Indexation_plantes.ipynb

Automatically generated by Colab.

Original file is located at
    https://colab.research.google.com/drive/16fYmTvdHCHU6hNVsU6XNjkZ_LoP-uBvr
"""

#pip install nltk

import sys
import json

#pip install psycopg2-binary

import psycopg2
conn = psycopg2.connect(database = "plante",
                        user = "plante_owner",
                        host= 'ep-bold-boat-a2s83w2r.eu-central-1.aws.neon.tech',
                        password = "1hnumc8qDlUi",
                        port = 5432)

#Open a cursor to perform database operations
cur = conn.cursor()

# Execute a command: create datacamp_courses table
cur.execute("""SELECT * FROM Plantes;""")
liste=cur.fetchall()


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
  conn = psycopg2.connect(database = "plante",
                        user = "plante_owner",
                        host= 'ep-bold-boat-a2s83w2r.eu-central-1.aws.neon.tech',
                        password = "1hnumc8qDlUi",
                        port = 5432)

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

# partie Karim
# liste des plantes avec le nom ayant le meme prefix que la requete

def liste_plantes_ayant_meme_prefixe_requete(mot):
    # Execute a command: create datacamp_courses table
    conn = psycopg2.connect(database="plante",
                      user="plante_owner",
                      host='ep-bold-boat-a2s83w2r.eu-central-1.aws.neon.tech',
                      password="1hnumc8qDlUi",
                      port=5432)
    cur = conn.cursor()
    cur.execute("""SELECT id,nom_commun,nom_scientifique FROM Plantes;""")
    liste_noms=cur.fetchall()
    liste_indices =[]
    for i in range (len(liste_noms)):
      id = liste_noms[i][0]
      nom1=liste_noms[i][1].lower()
      nom2=liste_noms[i][2].lower()
      if (nom1.startswith(mot.lower()) ):
        liste_indices.append(id)
    return liste_indices

"""# **The main program**"""

def programme_affichage_par_ordre_de_pertinance(word):
  ps = PorterStemmer()
  word=ps.stem(word)
  corpus=creation_corpus()
  filtered_corpus=filter_corpus(corpus)
  lemmatized_corpus=lemmatizer(filtered_corpus)
  liste_finale=pertinance_par_ordre(lemmatized_corpus,word)
  liste_matching_prefixe = liste_plantes_ayant_meme_prefixe_requete(word)
  for id in liste_matching_prefixe:
    if id not in liste_finale:
      liste_finale.append(id)
  return(liste_finale)











"""**essaie avec l'intelligence artificielle**"""

from sklearn.feature_extraction.text import TfidfVectorizer
stop_word = set(stopwords.words('english'))
corpus_train = [
    'I love programming in Python.',
    'Python is a great programming language.',
    'I enjoy solving problems with Python.',
    'Is programming in Python fun?',
]
corpus_test = [
    'Programming in Python is enjoyable.',
    'Python programming is very popular.',
    'Do you love solving problems with Python?',
    'Learning Python programming is rewarding.',
]
dict=[]
i=0
# for i in range(len(corpus_train)):
#     d=corpus_train[i]
#     tokens = word_tokenize(d)
#     filtered_text = " ".join(w for w in tokens if not (w in stop_word or w == "."))
#     print(filtered_text)
#     dict.append(filtered_text)
#     print(dict)
vectorizer = TfidfVectorizer()

X1=vectorizer.fit(corpus_train)
#print(X1.get_params())

X = vectorizer.fit_transform(corpus_train)
#print("deux" ,X)
Y = vectorizer.transform(corpus_test)
# print((X).toarray())
# print((Y).toarray())
td_idf=(X).toarray()
#print(vectorizer.get_feature_names_out(4))
liste_de_tf_idf_mot_indice_3=[w[3] for w in td_idf]
# print(liste_de_tf_idf_mot_indice_3)
# print(X.shape)

