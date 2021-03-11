pipeline {
  agent {
    node {
      label 'jenkins-agent-docker-1'
    }

  }
  stages {
    stage('') {
      steps {
        sh '''docker build -t lrx0014/examsys:v1.0

echo "build finished"'''
      }
    }

  }
}