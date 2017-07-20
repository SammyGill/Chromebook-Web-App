#include <stdio.h>
#include<stdlib.h>
#include<string.h>
#include<dirent.h>

#define MAX_STR 100
#define ASSET_LEN 4

void compareData(char *school, char *room, char *asset, char *status, char *assignment, char **unfoundChromebooks, int *index, FILE *stream) {
  char searchString[MAX_STR] = {0};
  FILE *fp = fopen("Chromebook Mass Export.csv", "r");
  if(fp == NULL) {
    printf("COULD NOT OPEN OTHER FILE\n");
    return;
  }
  while(fgets(searchString, MAX_STR, fp)) {
    searchString[strlen(searchString)] = '\0';

    char *massAsset = strtok(searchString, ",");
    char *serialNumber = strtok(NULL, ",");
    char *model = strtok(NULL, ",");
    model[strlen(model) - 2] = 0;

    if(strncmp(asset, massAsset, ASSET_LEN) == 0) {
      fprintf(stream, "%s,%s,%s,%s,%s,%s,%s", school, room, asset, serialNumber, model, status, assignment);
      fclose(fp);
      return;
    }
  }
  *unfoundChromebooks = calloc(strlen(asset) + 1, sizeof(char));
  strcpy(*unfoundChromebooks, asset);
  (*index)++;
  fclose(fp);
}

int main() {
  int unfoundIndex = 0;
  char *unfoundChromebooks[MAX_STR] = {0};
  DIR *path = opendir("Data");
  struct dirent *dp;
  FILE *writeFile = fopen("output.csv", "w");

  if(writeFile == NULL) {
    printf("COULD NOT OPEN OUTPUT FILE\n");
    return EXIT_FAILURE;
  }

  fprintf(writeFile, "School, Room, Asset, Serial Number, Model, Physical Status, Assignment Status\n");
  while((dp = readdir(path)) != NULL) {
    if(strcmp(dp->d_name, ".") == 0 || strcmp(dp->d_name, "..") == 0) {
      continue;
    }


    char string[MAX_STR] = {0};



    char dirName[MAX_STR] = "Data/";
    char fullPath[MAX_STR] = {0};
    strcpy(fullPath, dirName);
    strcat(fullPath, dp->d_name);
    FILE *fp = fopen(fullPath, "r");
    if(fp == NULL) {
      printf("COULD NOT OPEN FILE %s\n", dp->d_name);
    }
    else {
      printf("SUCCESSFULLY OPENED FILE %s\n", dp->d_name);
    }

    while(fgets(string, MAX_STR, fp)) {
      char *school = strtok(string, ",");
      char *room = strtok(NULL, ",");
      char *asset = strtok(NULL, ",");
      char *status = strtok(NULL, ",");
      char *assignment = strtok(NULL, ",");
      compareData(school, room, asset, status, assignment, &unfoundChromebooks[unfoundIndex], &unfoundIndex, writeFile);
    }
    printf("FINISHED READING FILE %s\n", dp->d_name);
    fclose(fp);
  }

  for(int i = 0; i < unfoundIndex; i++) {
    fprintf(writeFile, "COULD NOT FIND %s\n", unfoundChromebooks[i]);
  }

  for(int i = 0; i < unfoundIndex; i++) {
    free(unfoundChromebooks[i]);
  }

  fclose(writeFile);
  closedir(path);
  return EXIT_SUCCESS;
}
